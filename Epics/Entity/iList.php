<?php 

namespace Epics\Entity;

interface iList {
	function __construct( bool $init = true);
	function add( array $item );
	function order(string $type, string $direction = 'asc') : self;
	function filter(string $type, $value) : self;
	function result() : array;
	function cacheRaw(): array;
}
