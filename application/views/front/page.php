 
<!-- Page Title -->
<div class="page-title text-center">
    <h2 class="title"><?php echo @$content['title']; ?></h2> 
</div> 
<div class="container">

    <div class="row about-sidebar">

        <div class="col-md-12 about-content">

            <section class="about-company">

                <div class="com"> 
                    <?php if ($content['photo'] != ''){ ?>
					<img src="<?php echo base_url('uploads/contents/'.$content['photo']); ?>" width="100%">
					<?php } ?>
                    <?php echo $content['content']; ?>
                    <br><br><br><br><br><br><br>
                </div>
            </section> 

        </div>

        <!-- div class="col-md-3 sidebar left"> 

            <div class="sidebar-fact">

            </div>

        </div -->

    </div>

</div>
</main>
<!-- Main Content Section -->