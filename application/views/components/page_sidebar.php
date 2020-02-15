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
                      <img src="<?php echo (isset($member_details) AND $member_details->picture != '') ? $member_details->picture : ADMIN_IMAGES.'default-icon.png' ?>" class="img-circle" alt="">
                      </span>
                      <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt"><?php echo $member_details->first_name . ' ' . $member_details->last_name ?></strong> 
                          <b class="caret"></b>
                        </span>
                      </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">                      
                      <li>
                        <a href="<?php echo BASE_URL .'member/profile'?>">Profile</a>
                      </li>
                      <li>
                        <a href="<?php echo BASE_URL .'member/referral'?>">Referral Link</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="<?php echo isset($logout_url) ? $logout_url : BASE_URL.'user/logout'?>" >Logout</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <nav class="nav-primary hidden-xs">
                  <ul class="nav nav-main" data-ride="collapse">
                    <li class="<?php echo ( $this->uri->segment('1') == 'dashboard' OR $this->uri->segment('2') == 'eproducts' ) ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL .'dashboard'?>" class="auto">
                        <i class="fas fa-tachometer-alt icon">
                        </i>
                        <span class="font-bold">Dashboard</span>
                      </a>
                    </li>
                    <li class="<?php echo ( $this->uri->segment('1') == 'purchased'  OR $this->uri->segment('1') == 'view_address' OR $this->uri->segment('2') == 'store' OR $this->uri->segment('1') == 'buy_usd' OR $this->uri->segment('1') == 'buy_usd_request' ) ? 'active' : '' ?>">
                        <a class="auto">
                          <span class="pull-right text-muted">
                            <i class="i i-circle-sm-o text"></i>
                          </span>
                          <i class="fas fa-shopping-bag icon">
                          </i>
                          <span class="font-bold">Buy</span>
                        </a>
                        <ul class="nav dk">
                          <li>
                            <a href="<?php echo BASE_URL . 'purchased'?>" class="auto">                                                        
                              <i class="i i-dot"></i>
                              <span>Buy GHSbPoints</span>
                            </a>
                          </li>
                          <li>
                            <a href="<?php echo BASE_URL . 'buy_usd'?>" class="auto">                                                        
                              <i class="i i-dot"></i>
                              <span>Buy USDbPoints</span>
                            </a>
                          </li>
                        </ul>
                    </li>
                    <li class="<?php echo ($this->uri->segment('1') == 'withdraw' OR $this->uri->segment('1') == 'withdraw_usd') ? 'active' : '' ?>">
                      <a class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                        </span>
                        <i class="fas fa-exchange-alt icon">
                        </i>
                        <span class="font-bold">Withdraw</span>
                      </a>
                      <ul class="nav dk">
                          <li class="<?php echo $this->uri->segment('1') == 'withdraw' ? 'active' : ''?>">
                            <a href="<?php echo BASE_URL . 'withdraw'?>" class="auto">                                                        
                              <i class="i i-dot"></i>
                              <span>GHSe-Wallet Withdrawal</span>
                            </a>
                          </li>
                          <li class="<?php echo $this->uri->segment('1') == 'withdraw_usd' ? 'active' : ''?>">
                            <a href="<?php echo BASE_URL . 'withdraw_usd'?>" class="auto">                                                        
                              <i class="i i-dot"></i>
                              <span>USDe-Wallet Withdrawal</span>
                            </a>
                          </li>
                        </ul>
                    </li>
                    <li class="<?php echo ($this->uri->segment('2') == 'transfer' OR $this->uri->segment('1') == 'exchange_history' OR $this->uri->segment('1') == 'exchange' OR $this->uri->segment('1') == 'transfer_view' OR $this->uri->segment('1') == 'transfer' OR $this->uri->segment('1') == 'ewallet_history' OR  $this->uri->segment('1') == 'ewallet' )  ? 'active' : '' ?>">
                      <a class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                        </span>
                        <i class="icon fab fa-google-wallet">
                        </i>
                        <span class="font-bold">Finance</span>
                      </a>
                      <ul class="nav dk">
                         <li>
                          <a href="<?php echo BASE_URL . 'ewallet'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>E-wallet</span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo BASE_URL . 'transfer_view'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Credit/Debit</span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo BASE_URL . 'transfer'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Transfer History</span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo BASE_URL . 'exchange_history'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Exchange History</span>
                          </a>
                        </li>
                        <!-- <li>
                          <a href="<?php echo BASE_URL . 'exchange_history'?>" class="auto">                                                        
                            <i class="i i-dot"></i>
                            <span>Exchane History</span>
                          </a>
                        </li> -->
                      </ul>
                    </li>
                    <li class="<?php echo $this->uri->segment('1') == 'tree' ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'tree'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-tree icon">
                        </i>
                        <span class="font-bold">Tree List</span>
                      </a>
                    </li>
                    <li class="<?php echo $this->uri->segment('1') == 'testimonial' ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'testimonial'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fas fa-comment-alt icon">
                        </i>
                        <span class="font-bold">Add Testimonial</span>
                      </a>
                    </li>
                  <?php  if($member_details->is_eproduct_plan == 1) { ?>
                   <li class="<?php echo $this->uri->segment('1') == 'eProducts' ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'eProducts'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fab fa-product-hunt icon">
                        </i>
                        <span class="font-bold">eProducts</span>
                      </a>
                    </li>
                  <?php } ?> 
                  <li class="<?php echo $this->uri->segment('1') == 'resource' ? 'active' : '' ?>">
                      <a href="<?php echo BASE_URL . 'resource'?>" class="auto">
                        <span class="pull-right text-muted">
                        </span>
                        <i class="fa fa-book icon">
                        </i>
                        <span class="font-bold">Resources</span>
                      </a>
                    </li>
                    <li class="<?php echo ($this->uri->segment('1') == 'subscription' OR $this->uri->segment('1') == 'list_plan' or $this->uri->segment('1') == 'readme_boame')? 'active' : '' ?>">
                      <a  class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                        </span>
                        <i class="fab fa-gofore"></i>
                        </i>
                        <span class="font-bold">Boame Forex</span>
                      </a>
                      <ul class="nav dk">
                       <li class=<?php echo ($this->uri->segment('1') == 'subscription' OR $this->uri->segment('1') == 'list_plan') ? 'active':''?>>
                         <a href="<?php echo BASE_URL . 'subscription'?>" class="auto">                                                        
                           <i class="i i-dot"></i>
                           <span>Subscription</span>
                         </a>
                       </li>
                        <li class=<?php echo ($this->uri->segment('1') == 'readme_boame') ? 'active':''?>>
                         <a href="<?php echo BASE_URL . 'readme_boame'?>" class="auto">                                                        
                           <i class="i i-dot"></i>
                           <span>ReadMe Boame Fx</span>
                         </a>
                       </li>
                      </ul>
                    </li>
                   <li class="<?php echo ($this->uri->segment('2') == 'report' OR $this->uri->segment('1') == 'commission_report' OR $this->uri->segment('1') == 'joining_report' ) ? 'active' : '' ?> ">
                     <a class="auto">
                       <span class="pull-right text-muted">
                            <i class="i i-circle-sm-o text"></i>
                       </span>
                       <i class="fa fa-bar-chart-o icon">
                       </i>
                       <span class="font-bold">Report</span>
                     </a>
                     <ul class="nav dk">
                       <li>
                         <a href="<?php echo BASE_URL . 'commission_report'?>" class="auto">                                                        
                           <i class="i i-dot"></i>
                           <span>Commission History</span>
                         </a>
                       </li>
                        <li>
                         <a href="<?php echo BASE_URL . 'joining_report'?>" class="auto">                                                        
                           <i class="i i-dot"></i>
                           <span>Joining History</span>
                         </a>
                       </li>
                       <!-- <li>
                         <a href="<?php echo BASE_URL . 'transfer'?>" class="auto">                                                        
                           <i class="i i-dot"></i>
                           <span>Transfer History</span>
                         </a>
                       </li> -->
                     </ul>
                   </li>
                   
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>