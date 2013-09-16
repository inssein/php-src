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

/* Array representing a possible record set returned from a database */
$records = array(
   getMockObject(1, 'John', 'Doe'),
   getMockObject(2, 'Sally', 'Smith'),
   getMockObject(3, 'Jane', 'Jones')
);

$idCallable = function (stdClass $row) {
    return $row->id;
};

$firstNameCallable = function (stdClass $row) {
    return $row->first_name;
};

$lastNameCallable = function (stdClass $row) {
    return $row->last_name;
};

echo "*** Testing array_column() : callable functionality ***\n";

echo "-- first_name column from recordset --\n";
var_dump(array_column($records, $firstNameCallable));

echo "-- id column from recordset --\n";
var_dump(array_column($records, $idCallable));

echo "-- last_name column from recordset, keyed by value from id column --\n";
var_dump(array_column($records, $lastNameCallable, $idCallable));

echo "-- last_name column from recordset, keyed by value from first_name column --\n";
var_dump(array_column($records, $lastNameCallable, $firstNameCallable));

echo "-- pass null as second parameter to get back all columns indexed by third parameter --\n";
var_dump(array_column($records, null, $idCallable));

echo "-- pass null as second parameter and no third param to get back array_values(input) --\n";
var_dump(array_column($records, null));

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
-- pass null as second parameter to get back all columns indexed by third parameter --
array(3) {
  [1]=>
  object(stdClass)#1 (3) {
    ["id"]=>
    int(1)
    ["first_name"]=>
    string(4) "John"
    ["last_name"]=>
    string(3) "Doe"
  }
  [2]=>
  object(stdClass)#2 (3) {
    ["id"]=>
    int(2)
    ["first_name"]=>
    string(5) "Sally"
    ["last_name"]=>
    string(5) "Smith"
  }
  [3]=>
  object(stdClass)#3 (3) {
    ["id"]=>
    int(3)
    ["first_name"]=>
    string(4) "Jane"
    ["last_name"]=>
    string(5) "Jones"
  }
}
-- pass null as second parameter and no third param to get back array_values(input) --
array(3) {
  [0]=>
  object(stdClass)#1 (3) {
    ["id"]=>
    int(1)
    ["first_name"]=>
    string(4) "John"
    ["last_name"]=>
    string(3) "Doe"
  }
  [1]=>
  object(stdClass)#2 (3) {
    ["id"]=>
    int(2)
    ["first_name"]=>
    string(5) "Sally"
    ["last_name"]=>
    string(5) "Smith"
  }
  [2]=>
  object(stdClass)#3 (3) {
    ["id"]=>
    int(3)
    ["first_name"]=>
    string(4) "Jane"
    ["last_name"]=>
    string(5) "Jones"
  }
}
Done
