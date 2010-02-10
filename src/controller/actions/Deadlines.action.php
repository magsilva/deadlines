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

require_once('controller/Action.interface.php');

class DeadlinesAction implements Action
{
	public function view($args)
	{
		global $daoFactory;
		$result = array();
		
		$daoDeadline = $daoFactory->manufacture('Deadline');
		$deadlines = $daoDeadline->findAll();
		foreach ($deadlines as $deadline) {
			if ($deadline->getEventId() != NULL) {	
				$eventDao = $daoFactory->manufacture('Event');
				$event = $eventDao->read($deadline->getEventId());
				$publicationDao = $daoFactory->manufacture('Publication');
				$publication = $publicationDao->read($event->getPublicationId());
				$publication->event = $event;
			}
			if ($deadline->getPeriodicalId() != NULL) {
				$periodicalDao = $daoFactory->manufacture('Periodical');
				$periodical = $periodicalDao->read($deadline->getPeriodicalId());
				$publicationDao = $daoFactory->manufacture('Publication');
				$publication = $publicationDao->read($periodical->getPublicationId());
				$publication->periodical = $periodical;
			}
			$deadline->publication = $publication;
		}
		$result['deadlines'] = $deadlines;
				
		$eventTypeDao = $daoFactory->manufacture('EventType');
		$result['eventTypes'] = $eventTypeDao->findAll();
		
		$periodicalTypeDao = $daoFactory->manufacture('PeriodicalType');
		$result['periodicalTypes'] = $periodicalTypeDao->findAll();

		$publicationTypeDao = $daoFactory->manufacture('PublicationType');
		$result['publicationTypes'] = $publicationTypeDao->findAll();
				
		$workTypeDao = $daoFactory->manufacture('WorkType');
		$result['workTypes'] = $workTypeDao->findAll();
		
		
		return $result;
	}
}

?>