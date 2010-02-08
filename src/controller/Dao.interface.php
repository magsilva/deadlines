<?php
/*
Copyright (c) 2010 Marco Aurélio Graciotto Silva <magsilva@ironiacorp.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/


/**
 * Data Access Object (DAO)
 *
 * DAO objects are used to access the information of an object, information
 * which is or will be stored in a database, file, or anyother data persistence
 * format.
 */
interface Dao
{
	/**
	 * Create an object.
	 *
	 * @param $data The mandatory data to create the object.
	 * @return The created object with the mandatory data and any automatically
	 * generated data (such as an id).
	 */
	public function create($data);

	/**
	 * Read an existent object.
	 *
	 * @param $id The object id (usually an integer).
	 * @return The object read from the storage medium.
	 */
	public function read($id);

	/**
	 * Update the objet in the persistence mechanism.
	 *
	 * @param $object The object to be updated (stored).
	 */
	public function update($object);

	/**
	 * Delete the object from the persistence mechanism.
	 *
	 * @param $object the object to be deleted.
	 */
	public function delete($object);
	
	/**
	 * Find all the objects.
	 */
	public function findAll();
}

?>
