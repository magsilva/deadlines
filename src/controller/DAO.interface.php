<?php

/**
 * Data Access Object (DAO)
 *
 * DAO objects are used to access the information of an object, information
 * which is or will be stored in a database, file, or anyother data persistence
 * format.
 */
interface DAO
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
}

?>
