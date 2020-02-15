<section>
      <section class="hbox stretch">
        <!-- .aside -->
        <aside class="bg-black aside-md hidden-print hidden-xs" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb avatar pull-left m-r">                        
                         <img src="<?php echo ADMIN_PROFILE.$admin_details->image ?>"  class="dker" alt="">
                      </span>
                      <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt"><?php echo $admin_details->first_name . ' ' . $admin_details->last_name ?></strong> 
                          <b class="caret"></b>
                        </span>
                      </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">                      
                      <li>
                        <a href="<?php echo BASE_URL .'admin/security/logout'?>">Logout</a>
                      </li>
                    </ul>
                  </div>
                </div>                
                <nav class="nav-primary hidden-xs">
                  <ul class="nav nav-main" data-ride="collapse">
                    <li <?php echo $this->uri->segment(2) == 'dashboard' ? "class='active'" : ''?> >
                      <a href="<?php echo BASE_URL .'admin/dashboard'?>" class="auto">
                        <i class="i i-statistics icon">
                        </i>
                        <span class="font-bold">Dashboard</span>
                      </a>
                    </li>
                    <li <?php echo $this->uri->segment(2) == 'user' ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/user'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-users icon">
                        </i>
                        <span class="font-bold"> Users</span>
                      </a>
                    </li>
                    <li <?php echo $this->uri->segment(2) == 'news' ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/news'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-newspaper-o icon">
                        </i>
                        <span class="font-bold"> News</span>
                      </a>
                    </li>
                    <li <?php echo $this->uri->segment(2) == 'points' ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/points'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-file-text icon">
                        </i>
                        <span class="font-bold">Point Transaction Report</span>
                      </a>
                    </li>
                    <!-- <li <?php echo $this->uri->segment(2) == 'pledge' ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/pledge'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-tasks icon">
                        </i>
                        <span class="font-bold"> Pledge</span>
                      </a>
                    </li> -->
                    <!--  <li <?php echo $this->uri->segment(2) == 'purchased' ? "class='active'" : ''?>>
                     <a href="<?php echo BASE_URL . 'admin/purchased'?>" class="auto">
                       <span class="pull-right text-muted">
                       </span>
                       <i class="fa fa-money icon">
                       </i>
                       <span class="font-bold"> All Purchase History</span>
                     </a>
                      </li> -->
                    <li class="<?php echo ($this->uri->segment('2') == 'purchased' OR $this->uri->segment('2') == 'buy_usd' ) ? 'active' : '' ?>">
                     <a class="auto">
                       <span class="pull-right text-muted">
                         <i class="i i-circle-sm-o text"></i>
                       </span>
                       <i class="fa fa-shopping-cart">
                       </i>
                       <span class="font-bold">Buy Bpoints History</span>
                     </a>
                     <ul class="nav dk">
                         <li>
                           <a href="<?php echo BASE_URL . 'admin/purchased'?>" class="auto">                                                        
                             <i class="i i-dot"></i>
                             <span> GHSbPoint buy Requests</span>
                           </a>
                         </li> 
                         <li>
                           <a href="<?php echo BASE_URL . 'admin/buy_usd'?>" class="auto">                                                        
                             <i class="i i-dot"></i>
                             <span> USDbPoint buy Requests</span>
                           </a>
                         </li> 
<!--                          <li>
                           <a href="<?php echo BASE_URL . 'admin/purchased/inprogress'?>" class="auto">                                                        
                             <i class="i i-dot"></i>
                             <span> In-progress Requests</span>
                           </a>
                         </li>
                          <li>
                           <a href="<?php echo BASE_URL . 'admin/purchased/pending'?>" class="auto">                                                        
                             <i class="i i-dot"></i>
                             <span> Pending Requests</span>
                           </a>
                         </li>
                          <li>
                           <a href="<?php echo BASE_URL . 'admin/purchased/completed'?>" class="auto">                                                        
                             <i class="i i-dot"></i>
                             <span> Completed Requests</span>
                           </a>
                         </li>
                          <li>
                           <a href="<?php echo BASE_URL . 'admin/purchased/cancel_user'?>" class="auto">                                                        
                             <i class="i i-dot"></i>
                             <span>Canceled By User</span>
                           </a>
                         </li>
                        <li>
                          <a href="<?php echo BASE_URL . 'admin/purchased/cancel_admin'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Canceled By Admin</span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo BASE_URL . 'admin/purchased/cancel_system'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Canceled By System</span>
                          </a>
                       </li>-->
                     </ul>
                  </li>
                  <li class="<?php echo ($this->uri->segment('2') == 'withdraw' )  ? 'active' : '' ?>">
                     <a class="auto">
                       <span class="pull-right text-muted">
                         <i class="i i-circle-sm-o text"></i>
                       </span>
                       <i class="fa fa-exchange">
                       </i>
                       <span class="font-bold"> Withdrawal History</span>
                     </a>
                    <ul class="nav dk">
                     <li class="<?php echo ($this->uri->segment('3') == 'pending_index' )  ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'admin/withdraw/pending_index'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="i i-dot">
                        </i>
                        <span class="font-bold">Pending GHS-Request</span>
                      </a>
                    </li> 
                    <li class="<?php echo ($this->uri->segment('3') == 'complete_index' )  ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'admin/withdraw/complete_index'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="i i-dot">
                        </i>
                        <span class="font-bold">Completed GHS-Request</span>
                      </a>
                    </li>
                     <li class="<?php echo ($this->uri->segment('3') == 'cancel_index' )  ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'admin/withdraw/cancel_index'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="i i-dot">
                        </i>
                        <span class="font-bold">Cancel GHS-Request</span>
                      </a>
                    </li>
                    <li class="<?php echo ($this->uri->segment('3') == 'u_pending_index' )  ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'admin/withdraw/u_pending_index'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="i i-dot">
                        </i>
                        <span class="font-bold">Pending USD-Request</span>
                      </a>
                    </li> 
                    <li class="<?php echo ($this->uri->segment('3') == 'u_complete_index' )  ? 'active' : '' ?>">
                      <!-- <a href="#" class="auto"> -->
                      <a href="<?php echo BASE_URL . 'admin/withdraw/u_complete_index'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="i i-dot">
                        </i>
                        <span class="font-bold">Completed USD-Request</span>
                      </a>
                    </li>
                     <li class="<?php echo ($this->uri->segment('3') == 'u_cancel_index' )  ? 'active' : '' ?>">
                      <!-- <a href="#" class="auto"> -->
                      <a href="<?php echo BASE_URL . 'admin/withdraw/u_cancel_index'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="i i-dot">
                        </i>
                        <span class="font-bold">Cancel USD-Request</span>
                      </a>
                    </li>
                  </ul>
                  </li>  
                  <li <?php echo $this->uri->segment(2) == 'transfer' ? "class='active'" : ''?>>
                    <a class="auto">
                       <span class="pull-right text-muted">
                         <i class="i i-circle-sm-o text"></i>
                       </span>
                       <i class="fa fa-list">
                       </i>
                       <span class="font-bold">Transfer History</span>
                     </a>
                     <ul class="nav dk">
                        <li>
                          <a href="<?php echo BASE_URL . 'admin/transfer'?>" class="auto">
                            <span class="pull-right text-muted">
                            </span>
                            <i class="i i-dot"></i>
                            <span class="font-bold"> GHS-bPoints History</span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo BASE_URL . 'admin/transfer/index_usd'?>" class="auto">
                            <span class="pull-right text-muted">
                            </span>
                            <i class="i i-dot">
                            </i>
                            <span class="font-bold">USD-bPoints History</span>
                          </a>
                        </li>
                    </ul>
                  </li>
                    <li <?php echo $this->uri->segment(2) == 'exchange' ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/exchange'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-table icon">
                        </i>
                        <span class="font-bold"> Exchange History</span>
                      </a>
                    </li>
                    <li <?php echo ($this->uri->segment(3) == 'Subscription_history' AND $this->uri->segment(2) == 'Subscription' ) ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/Subscription/Subscription_history'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-bar-chart"></i> 
                        <span class="font-bold">Subscription History</span>
                      </a>
                    </li>
                     <li <?php echo $this->uri->segment(2) == 'contact' ? "class='active'" : ''?>>
                      <a href="<?php echo BASE_URL . 'admin/contact'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-envelope icon">
                        </i>
                        <span class="font-bold"> Contact Inquiries</span>
                      </a>
                    </li>
                    <!--  -->
                    <li <?php echo $this->uri->segment(2) == 'resource' ? "class='active'" : ''?>>
                     <a href="<?php echo BASE_URL . 'admin/resource'?>" class="auto">
                       <span class="pull-right text-muted">
                       </span>
                       <i class="fa fa-plus-square icon">
                       </i>
                       <span class="font-bold">Resource Management</span>
                     </a>
                   </li>
                   <li <?php echo $this->uri->segment(2) == 'all' ? "class='active'" : ''?>>
                    <a href="<?php echo BASE_URL . 'admin/all'?>" class="auto">
                      <span class="pull-right text-muted">
                      </span>
                     <i class="fa fa-history"></i>
                      <span class="font-bold">All Point History</span>
                    </a>
                  </li>
                 
                  <li <?php echo $this->uri->segment(2) == 'testimonial' ? "class='active'" : ''?>>
                    <a href="<?php echo BASE_URL . 'admin/testimonial'?>" class="auto">
                      <span class="pull-right text-muted">
                      </span>
                     <i class="fa fa-file"></i>
                      <span class="font-bold">Manage Testimonials</span>
                    </a>
                  </li>
                  <li <?php echo $this->uri->segment(2) == 'Eproducts' ? "class='active'" : ''?>>
                    <a href="<?php echo BASE_URL . 'admin/Eproducts'?>" class="auto">
                      <span class="pull-right text-muted">
                      </span>
                     <i class="fa fa-book"></i>
                      <span class="font-bold">Manage eProducts</span>
                    </a>
                  </li>
                  <li <?php echo $this->uri->segment(3) == 'index' ? "class='active'" : ''?>>
                    <a href="<?php echo BASE_URL . 'admin/Subscription/index'?>" class="auto">
                      <span class="pull-right text-muted">
                      </span>
                     <i class="fa fa-plus"></i>
                      <span class="font-bold">Manage Plans</span>
                    </a>
                  </li>
                  <li <?php echo $this->uri->segment(2) == 'Settings' ? "class='active'" : ''?>>
                    <a href="<?php echo BASE_URL . 'admin/Settings'?>" class="auto">
                      <span class="pull-right text-muted">
                      </span>
                     <i class="fa fa-cog"></i>
                      <span class="font-bold">Settings</span>
                    </a>
                  </li>
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>