<?php
$this->Html->addCrumb($page['title'], ['action' => 'index']);
$this->assign('title', $page['title']);

$title = $page['title'];

$description = $this->Text->truncate(strip_tags($page['description']), 150, ['exact' => false]);

$meta = null;

$meta .= $this->Html->meta('description', $description);


$this->assign('meta', $meta);

$this->layout = 'fullpage';
?>
<div class="page-breadcrumbs">
	<h1 class="section-title"><?= $page['title']; ?></h1>	
	<div class="world-nav cat-menu"> 
		<?php
			echo $this->Html->getCrumbList(
			[
			'lastClass' => 'active',
			'class' => 'list-inline',
			], ['text' => 'Home',
			'url' => ['controller' => 'pages', 'action' => 'display','home'],]
			);
		?>
		</div>
	</div>

	<?php echo $page['description']; ?>
