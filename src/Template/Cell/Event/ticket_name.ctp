<?php
use Cake\Utility\Hash;
$tickets = Hash::combine($tickets, '{n}.name','{n}.name');
echo implode(', ', $tickets);

?>
