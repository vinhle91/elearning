<?php if(isset($messages)) : ?>

<table border="1" align="center" id="mylesson">
    <tbody>
    <tr style="font-size:18px; color:blue; font-weight:800;text-align:center">
        <td width="5%" style="background-color: #eee;">番号</td>
        <td width="5%" style="background-color: #eee;">内容</td>
        <td width="10%" style="background-color: #eee;">日付</td>
<!--        <td width="25%" style="background-color: #eee;">--><?php //echo $paginator->sort('User.Username', '先生')?><!--</td>-->
<!--        <td width="10%" style="background-color: #eee;">--><?php //echo $paginator->sort('User.totalLesson', '授業')?><!--</td>-->
<!--        <td width="10%" style="background-color: #eee;">--><?php //echo $paginator->sort('User.totalLike', 'いいね')?><!--</td>-->
<!--        <td width="10%" style="background-color: #eee;">--><?php //echo $paginator->sort('User.totalView', 'ビュー')?><!--</td>-->
<!--        <td width="30%" style="background-color: #eee;">--><?php //echo $paginator->sort('User.Email', 'メール')?><!--</td>-->
    </tr>
    <?php foreach($messages as $t) {
        $i = 1; ?>
        <tr>
            <td><?php echo $i++;?></td>
<!--            <td>--><?php //echo $this->Html->image('icon/avatar_2.jpg', array('alt' => 'Avatar', 'width' => '65', 'height' => '70')); ?><!--</td>-->
            <td><?php echo $t['msg']['Content'];?></td>
            <td><?php echo $t['msg']['created'];?></td>
<!--            <td>--><?php //echo $t['User']['totalLike'];?><!--</td>-->
<!--            <td>--><?php //echo $t['User']['totalView'];?><!--</td>-->
<!--            <td>--><?php //echo $t['User']['Email'];?><!--</td>-->
        </tr>
    <?php }?>
    <?php unset($t); ?>
    </tbody>
</table>
 <?php endif; ?>
<?php if(!$messages) : ?>
<h2>あなたにはメッセージがありません</h2>

<?php endif; ?>