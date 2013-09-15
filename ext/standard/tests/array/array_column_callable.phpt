--TEST--
Test array_column() function: callable functionality
--FILE--
<?php
/* Prototype:
 *  array array_column(array $input, mixed $column_key[, mixed $index_key]);
 * Description:
 *  Returns an array containing all the values from
 *  the specified "column" in a two-dimensional array.
 */

// defining a function and some callable's we will use in this test first
function getMockObject($id, $firstName, $lastName)
{
    $obj = new stdClass();
    $obj->id = $id;
    $obj->first_name = $firstName;
    $obj->last_name = $lastName;

    return $obj;
};

$idCallable = function (stdClass $row) {
    return $row->id;
};

$firstNameCallable = function (stdClass $row) {
    return $row->first_name;
}

$lastNameCallable = function (stdClass $row) {
    return $row->last_name;
}

echo "*** Testing array_column() : callable functionality ***\n";

/* Array representing a possible record set returned from a database */
$records = array(
   $this->getMockObject(1, 'John', 'Doe'),
   $this->getMockObject(2, 'Sally', 'Smith'),
   $this->getMockObject(3, 'Jane', 'Jones')
);

echo "-- first_name column from recordset --\n";
var_dump(array_column($records, $firstNameCallable));

echo "-- id column from recordset --\n";
var_dump(array_column($records, $idCallable));

echo "-- last_name column from recordset, keyed by value from id column --\n";
var_dump(array_column($records, $lastNameCallable, $idCallable));

echo "-- last_name column from recordset, keyed by value from first_name column --\n";
var_dump(array_column($records, $lastNameCallable, $firstNameCallable));

echo "Done\n";
?>
--EXPECTF--
*** Testing array_column() : callable functionality ***
-- first_name column from recordset --
array(3) {
  [0]=>
  string(4) "John"
  [1]=>
  string(5) "Sally"
  [2]=>
  string(4) "Jane"
}
-- id column from recordset --
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
-- last_name column from recordset, keyed by value from id column --
array(3) {
  [1]=>
  string(3) "Doe"
  [2]=>
  string(5) "Smith"
  [3]=>
  string(5) "Jones"
}
-- last_name column from recordset, keyed by value from first_name column --
array(3) {
  ["John"]=>
  string(3) "Doe"
  ["Sally"]=>
  string(5) "Smith"
  ["Jane"]=>
  string(5) "Jones"
}

Done
