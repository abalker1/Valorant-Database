<?php
class Agent {
	public $id;
	public $agentName;
	public $realName;
	public $gender;
	public $age;
	public $role;
	public $img;
	


	function GetId() {
		return $this->id;
	}
	function SetId($i) {
		$this->id = $i;
	}
	
	function GetAgentName() {
		return $this->agent_name;
	}
	function SetAgentName($an) {
		$this->agent_name = $an;
	}
	
	function GetRealName() {
		return $this->real_name;
	}
	function SetRealName($rn) {
		$this->real_name = $rn;
	}
	
	function GetGender() {
		return $this->gender;
	}
	function SetGender($g) {
		$this->gender = $g;
	}
	
	function GetAge() {
		return $this->age;
	}
	function SetAge($a) {
		$this->age = $a;
	}
	
	function GetRole() {
		return $this->role;
	}
	function SetRole($r) {
		$this->role = $r;
	}
	
	function getImg() {
		return $this->img;
	}
	
	function setImg($i){
		$this->img = $i;
	}
	
	public function __construct($agentName, $realName, $gender, $age, $role, $img = "Logo.png") {
		$this->SetAgentName($agentName);
		$this->SetRealName($realName);
		$this->SetGender($gender);
		$this->SetAge($age);
		$this->SetRole($role);
		$this->SetImg($img);
	}
}



?>