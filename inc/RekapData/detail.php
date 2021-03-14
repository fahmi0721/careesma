<?php
$ls = LoadDataJobVa();

?>
<div class="row">
<?php
$color = array("maroon","yellow","green","purple","red");
foreach($ls as $key => $iData){
    $clr = $color[array_rand($color)];

?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a href='index.php?page=Applicanto&Id=<?= $iData['Id'] ?>'>
          <div class="info-box">
            <span class="info-box-icon bg-<?= $clr ?>"><i class="fa fa-graduation-cap"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><?= $iData['Judul'] ?></span>
              <span class="info-box-number"><?= rupiah1($iData['Tot']); ?></span>
            </div>
            <!-- /.info-box-content -->
           </div>
        </a>
    </div>
<?php } ?>
</div>