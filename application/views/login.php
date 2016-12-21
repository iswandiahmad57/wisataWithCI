<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laboratorium Desain Sistem Kerja Dan Ergonomis| </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('asset/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('asset/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('asset/build/css/custom.min.css');?>" rel="stylesheet">
    <style type="text/css">
      .field_error .message{
        color:red;
      }
    </style>
  </head>

  <body class="login">
  <?php $flash_info = $this->session->flashdata('success-info')?>
<?php if (! empty($flash_info)) : ?>
    <div class="pesan" style="text-align:center">
        <?php echo $flash_info; ?>
    </div>
<?php endif ?>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php
    $attributes = array('name' => 'login_form', 'id' => 'login_form');
    echo form_open(base_url().$action, $attributes);
  ?>

    <!-- pesan start -->
    <?php if (! empty($pesan)) : ?>
        <p id="message">
            <?php echo $pesan; ?>
        </p>
    <?php endif ?>
    <!-- pesan end -->
        
              <h1>Login Form</h1>
              <div>
              <label for="username">Username:</label>
                <input type="text" name="username" size="20" class="form-control" value="<?php echo set_value('username');?>">
              </div>
              <?php echo form_error('username', '<p class="field_error">', '</p>');?>
    
              <div>
              <label for="password">Password:</label>
                <input type="password" name="password" size="20" class="form-control" value="<?php echo set_value('password');?>">
              </div>
              <?php echo form_error('password', '<p class="field_error">', '</p>');?>
              <div>
                <button class="btn btn-default submit" type="submit">Log in</button>
         
              </div>

              <div class="clearfix"></div>

              <div class="separator">


                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>


      </div>
    </div>
  </body>
</html>