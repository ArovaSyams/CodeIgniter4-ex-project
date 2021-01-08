<?php

declare(strict_types=1);

namespace Rector\MysqlToMysqli\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\LNumber;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\RectorDefinition\CodeSample;
use Rector\Core\RectorDefinition\RectorDefinition;
use Rector\NodeTypeResolver\Node\AttributeKey;

/**
 * @see https://www.phpclasses.org/blog/package/9199/post/3-Smoothly-Migrate-your-PHP-Code-using-the-Old-MySQL-extension-to-MySQLi.html
 * @see \Rector\MysqlToMysqli\Tests\Rector\Assign\MysqlAssignToMysqliRector\MysqlAssignToMysqliRectorTest
 */
final class MysqlAssignToMysqliRector extends AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const FIELD_TO_FIELD_DIRECT = [
        'mysql_field_len' => 'length',
        'mysql_field_name' => 'name',
        'mysql_field_table' => 'table',
    ];

    /**
     * @var string
     */
    private const MYSQLI_DATA_SEEK = 'mysqli_data_seek';

    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition(
            'Converts more complex mysql functions to mysqli',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$data = mysql_db_name($result, $row);
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
mysqli_data_seek($result, $row);
$fetch = mysql_fetch_row($result);
$data = $fetch[0];
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return string[]
     */
    public function getNodeTypes(): array
    {
        return [Assign::class];
    }

    /**
     * @param Assign $node
     */
    public function refactor(Node $node): ?Node
    {
        if (! $node->expr instanceof FuncCall) {
            return null;
        }

        /** @var FuncCall $funcCallNode */
        $funcCallNode = $node->expr;

        if ($this->isName($funcCallNode, 'mysql_tablename')) {
            return $this->processMysqlTableName($node, $funcCallNode);
        }

        if ($this->isName($funcCallNode, 'mysql_db_name')) {
            return $this->processMysqlDbName($node, $funcCallNode);
        }

        if ($this->isName($funcCallNode, 'mysql_db_query')) {
            return $this->processMysqliSelectDb($node, $funcCallNode);
        }

        if ($this->isName($funcCallNode, 'mysql_fetch_field')) {
            return $this->processMysqlFetchField($node, $funcCallNode);
        }

        if ($this->isName($funcCallNode, 'mysql_result')) {
            return $this->processMysqlResult($node, $funcCallNode);
        }

        return $this->processFieldToFieldDirect($node, $funcCallNode);
    }

    private function processMysqlTableName(Assign $assign, FuncCall $funcCall): FuncCall
    {
        $funcCall->name = new Name(self::MYSQLI_DATA_SEEK);

        $newFuncCall = new FuncCall(new Name('mysql_fetch_array'), [$funcCall->args[0]]);
        $newAssignNode = new Assign($assign->var, new ArrayDimFetch($newFuncCall, new LNumber(0)));

        $this->addNodeAfterNode($newAssignNode, $assign);

        return $funcCall;
    }

    private function processMysqlDbName(Assign $assign, FuncCall $funcCall): FuncCall
    {
        $funcCall->name = new Name(self::MYSQLI_DATA_SEEK);

        $mysqlFetchRowFuncCall = new FuncCall(new Name('mysqli_fetch_row'), [$funcCall->args[0]]);
        $fetchVariable = new Variable('fetch');
        $newAssignNode = new Assign($fetchVariable, $mysqlFetchRowFuncCall);
        $this->addNodeAfterNode($newAssignNode, $assign);

        $newAssignNode = new Assign($assign->var, new ArrayDimFetch($fetchVariable, new LNumber(0)));
        $this->addNodeAfterNode($newAssignNode, $assign);

        return $funcCall;
    }

    private function processMysqliSelectDb(Assign $assign, FuncCall $funcCall): FuncCall
    {
        $funcCall->name = new Name('mysqli_select_db');

        $newAssignNode = new Assign($assign->var, new FuncCall(new Name('mysqli_query'), [$funcCall->args[1]]));
        $this->addNodeAfterNode($newAssignNode, $assign);

        unset($funcCall->args[1]);

        return $funcCall;
    }

    private function processMysqlFetchField(Assign $assign, FuncCall $funcCall): Assign
    {
        if (isset($funcCall->args[1])) {
            $funcCall->name = new Name('mysqli_fetch_field_direct');
        } else {
            $funcCall->name = new Name('mysqli_fetch_field');
        }

        return $assign;
    }

    private function processMysqlResult(Assign $assign, FuncCall $funcCall): FuncCall
    {
        $fetchField = null;
        if (isset($funcCall->args[2])) {
            $fetchField = $funcCall->args[2]->value;
            unset($funcCall->args[2]);
        }

        $funcCall->name = new Name(self::MYSQLI_DATA_SEEK);

        $mysqlFetchArrayFuncCall = new FuncCall(new Name('mysqli_fetch_array'), [$funcCall->args[0]]);
        $fetchVariable = new Variable('fetch');
        $newAssignNode = new Assign($fetchVariable, $mysqlFetchArrayFuncCall);
        $this->addNodeAfterNode($newAssignNode, $assign);

        $newAssignNode = new Assign($assign->var, new ArrayDimFetch($fetchVariable, $fetchField ?? new LNumber(0)));
        $this->addNodeAfterNode($newAssignNode, $assign);

        return $funcCall;
    }

    private function processFieldToFieldDirect(Assign $assign, FuncCall $funcCall): ?Assign
    {
        foreach (self::FIELD_TO_FIELD_DIRECT as $funcName => $property) {
            if ($this->isName($funcCall, $funcName)) {
                $parentNode = $funcCall->getAttribute(AttributeKey::PARENT_NODE);
                if ($parentNode instanceof PropertyFetch || $parentNode instanceof StaticPropertyFetch) {
                    continue;
                }

                $funcCall->name = new Name('mysqli_fetch_field_direct');
                $assign->expr = new PropertyFetch($funcCall, $property);

                return $assign;
            }
        }

        return null;
    }
}