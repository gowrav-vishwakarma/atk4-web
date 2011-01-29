<?php
class IndexTabs extends View {
	function init(){
		parent::init();

		// This will make sure content we add here will pass our current setting along
		$this->api->stickyGET($this->name);

		$this->js(true)->_selector('#actionbar')->_load('ui.atk4_menu')->atk4_menu(array(
			'target'=>$this,
			'cut_object'=>$this->name,
			'cut_page'=>false
					));

		$this->api->template->set('link_comparison',$u=$this->api->getDestinationURL(null,array($this->name=>null)));
		$this->api->template->set('link_example',$u=$this->api->getDestinationURL(null,array($this->name=>'example')));
		$this->api->template->set('link_tour',$this->api->getDestinationURL(null,array($this->name=>'tour')));

		switch($_GET[$this->name]){
			case'example':

				$p=$this;
				$this->add('Doc_Example',null,'example')
					->setDescr(<<<'EOT'
$f=$p->add('Form');
$f->addField('line','name')->validateNotNull();
$f->addField('line','surname');
$f->addSubmit();
if($f->isSubmitted()){
  $f->js()->univ()->alert('Thank you, '.$f->get('name').
	  ' '.$f->get('surname'))->execute();
}
EOT
);

					// Same as above
$f=$p->add('Form',null,'form');
$f->addField('line','name')->validateNotNull();
$f->addField('line','surname');
$f->addButton('Try me')->js('click',$f->js()->submit());
if($f->isSubmitted()){
  $f->js()->univ()->alert('Thank you, '.$f->get('name').' '.$f->get('surname'))->execute();
}



				break;

			case'tour':
				$this->add('MagicIntro');
				break;

			default:
				$this->js(true)->univ()->indexCompareSwitch();
				break;
		}



		/*
		$u=clone $u;
		$this->js(true)->_selector('#example')->click(
				$this->js()->_enclose(null,true)->atk4_load($u->setArguments(array('cut_object'=>$this->name)))
				);
		$this->api->template->set('link_tour',$this->api->getDestinationURL(null,array($this->name=>'tour')));

		*/
	}
	function defaultTemplate(){
		switch($_GET[$this->name]){
			case'example':
				return array('view/index/tab_example');
			case'tour':
				return 'Content';
			default:
				return array('view/index/tab_compare');
		}
	}
}