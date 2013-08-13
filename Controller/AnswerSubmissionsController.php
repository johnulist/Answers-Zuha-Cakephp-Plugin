<?php
App::uses('AnswersAppController', 'Answers.Controller');

class _AnswerSubmissionsController extends AnswersAppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'AnswerSubmissions';

/**
 * Uses
 *
 * @var string
 */
	public $uses = array('Answers.AnswerSubmission', 'Answers.Answer', 'Answers.AnswerAnswer', 'Contact.Contact');


	public function index ( $id = null ) {

		if ( !empty($id) ) {
			$this->paginate['conditions'][] = array('AnswerSubmission.answer_id' => $id);
		}

		$this->paginate['contain'] = array(
			'Answer' => array(
				'fields' => array(
					'id',
					'title'
				)
			),
			'User' => array(
				'fields' => array(
					'id',
					'full_name'
				)
			)
			);
		$this->paginate['order'] = array('AnswerSubmission.created' => 'DESC');
		$this->AnswerSubmission->recursive = 0;
		$this->set('submissions', $this->paginate());
	}


	public function view ( $id ) {
		if ( empty($id) ) {
			$this->Session->setFlash('Invalid request');
			$this->redirect($this->referer());
		}

		$this->AnswerSubmission->id = $id;
		$data = $this->AnswerSubmission->find('first', array(
			'contain' => array(
				'AnswerAnswer',
				'User' => array(
					'fields' => array(
						'id',
						'full_name'
					)
				)
			)
		));
		$this->set('data', $data);

	}

}

if (!isset($refuseInit)) {
	class AnswerSubmissionsController extends _AnswerSubmissionsController {}
}