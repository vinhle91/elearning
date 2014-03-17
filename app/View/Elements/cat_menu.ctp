<div id="cat_menu">
    <h3 class="m_main"><span>カテゴリ</span></h3>
    <ul class="menu">
        <?php foreach ($categories as $category): ?>
            <li> <?php $catName = $category['Category']['CatName'];
            if($userType ==1) {
                echo $this->Html->link($catName, array('controller'=>'Student', 'action' => 'view_category', $category['Category']['CatId']));
            } else {
                echo $this->Html->link($catName, array('controller'=>'Teacher', 'action' => 'view_category', $category['Category']['CatId']));
            }
            ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>