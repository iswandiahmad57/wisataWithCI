
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <div class="nav toggle">
                 <button type="button" class="btn btn-default btn-md" back-button="" ng-click=""><i class="fa fa-arrow-left"></i> Back</button>
                
              </div>
              <div class="nav toggle">
                 <button type="button" class="btn btn-default btn-md" forward-button="" ng-click="">Forward <i class="fa fa-arrow-right"></i></button>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url().'asset/new/images/user.png';?>" alt=""><?php echo $this->session->userdata('username');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    
                    <li>
                      <a onclick="changePassword()">
                        <i class="fa fa-key pull-right"></i>
                        <span>change password</span>
                      </a>
                    </li>
                    
                    <li><a href="<?php echo base_url('login/logout');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>


              </ul>
            </nav>
          </div>
        </div>