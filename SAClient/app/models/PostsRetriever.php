<?php

abstract class PostsRetriever
{
	public function retrieve($query, $tags)
	{
		$this->posts = array();
		$this->makeRequest($query, $tags);
		return $this->posts;
	}

	protected abstract function makeRequest($query, $tags);
	
	protected function addPost($text, $tags)
	{
		array_push($this->posts, array(
			'id' => uniqid(),
			'text' => $text,
			'tags' => $tags
		));
	}
}