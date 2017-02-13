<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/favicon-32x32.png') ?>">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Almighty Referrer</title>

        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/navbar.css') ?>" rel="stylesheet">

        <script src="<?php echo base_url('assets/jquery/jquery-2.2.2.min.js') ?>"></script>
        <script>
            $(document).ready(function() {
               $('#image').change(function() {
                   //location.href = '<?php echo base_url().strtolower($this->router->fetch_class()) ?>/index/' + $('#channel').val();
                   $('#preview')[0].src = 'https://s3.amazonaws.com/alegrium-www/almighty/images/shorten/' + $('#image').val();
               }); 
            });
            
            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {
                    $('#selected_file')[0].innerHTML = label;
                    console.log(numFiles);
                    console.log(label);
                });
            });
        </script>
    </head>
    <body>

        <div class="container">

            <!-- Static navbar -->
            <?php $this->load->view ('navbar'); ?>

            <h3>Almighty - Referrer</h3>

            <br/>
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                </div>
                <div class="form-group">
                    <label for="image" class="col-sm-2 control-label" style="text-align: left;">Available Image</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="image" name="image" >
                            <?php
                            foreach ($list_image_referrer as $value) {
                                echo "<option ". (($value == $row_referrer['image']) ? "selected" : "")  .">$value</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <img id="preview" src="https://s3.amazonaws.com/alegrium-www/almighty/images/shorten/<?php echo $row_referrer['image']; ?>" 
                             border="0" width="600px" height="315px">
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label" style="text-align: left;">New Image</label>
                    <div class="col-sm-6">
                        <label class="btn btn-default btn-file">
                            Browse <input type="file" name="new_image" style="display: none;">                            
                        </label>
                        &nbsp;&nbsp;
                        <span id="selected_file"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label" style="text-align: left;">Title</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $row_referrer['title'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label" style="text-align: left;">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" rows="5" id="description" name="description" placeholder="Description" ><?php echo $row_referrer['description'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                </div>
            </form>

        </div>

        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

    </body>
</html>