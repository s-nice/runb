<?php
class ModelCatalogAskquestion extends Model {
	public function addQuestionAnswer($questionProductId,$questionerName,$questionerAnswer,$questionStatus)
	{
		$createTable=$this->db->query("CREATE TABLE IF NOT EXISTS `product_questions` (
				`id` bigint(20) NOT NULL auto_increment,
				`product_id` bigint(20) NOT NULL,
				`user_name` varchar(255) NOT NULL,
				`product_question` longtext NOT NULL,
				`product_answer` longtext NOT NULL,
				`product_status` int(11) NOT NULL,
				`product_question_helpfull` int(11) NOT NULL,
				`product_question_nothelpfull` int(11) NOT NULL,
				`question_asked_date` date NOT NULL,
				`question_answred_date` date NOT NULL,
				PRIMARY KEY  (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
		
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "product_questions SET product_id = '" . $questionProductId. "',user_name = '" . $questionerName. "', product_question = '" . $questionerAnswer . "', product_status = '" . $questionStatus . "', question_asked_date = NOW()");
	
	}
}
?>