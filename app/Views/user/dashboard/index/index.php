<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
	<div class="kt-header-mobile__brand">
		<a class="kt-header-mobile__logo" href="?page=index">
			<img alt="Logo"
				src="<?= base_url(); ?>/assets/media/logos/logo-5-sm.png" />
		</a>
		<div class="kt-header-mobile__nav">
			<div class="dropdown">
				<button type="button" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="true">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
						height="24px" viewBox="0 0 24 24" version="1.1"
						class="kt-svg-icon kt-svg-icon--md kt-svg-icon--success">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<path
								d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z"
								fill="#000000" fill-rule="nonzero" opacity="0.3" />
							<path
								d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z"
								fill="#000000" />
						</g>
					</svg> </button>
				<div class="dropdown-menu dropdown-menu-fit dropdown-menu-md">
					<ul class="kt-nav kt-nav--bold kt-nav--md-space kt-margin-t-20 kt-margin-b-20">
						<li class="kt-nav__item">
							<a class="kt-nav__link active" href="#">
								<span class="kt-nav__link-icon"><i class="flaticon2-user"></i></span>
								<span class="kt-nav__link-text">Human Resources</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a class="kt-nav__link" href="#">
								<span class="kt-nav__link-icon"><i class="flaticon-feed"></i></span>
								<span class="kt-nav__link-text">Customer Relationship</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a class="kt-nav__link" href="#">
								<span class="kt-nav__link-icon"><i class="flaticon2-settings"></i></span>
								<span class="kt-nav__link-text">Order Processing</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a class="kt-nav__link" href="#">
								<span class="kt-nav__link-icon"><i class="flaticon2-chart2"></i></span>
								<span class="kt-nav__link-text">Accounting</span>
							</a>
						</li>
						<li class="kt-nav__separator"></li>
						<li class="kt-nav__item">
							<a class="kt-nav__link" href="#">
								<span class="kt-nav__link-icon"><i class="flaticon-security"></i></span>
								<span class="kt-nav__link-text">Finance</span>
							</a>
						</li>
						<li class="kt-nav__item">
							<a class="kt-nav__link" href="#">
								<span class="kt-nav__link-icon"><i class="flaticon2-cup"></i></span>
								<span class="kt-nav__link-text">Administration</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="kt-header-mobile__toolbar">
		<button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
		<button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
				class="flaticon-more-1"></i></button>
	</div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">

			<!-- begin:: Header -->
			<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
				<div class="kt-header__top">
					<div class="kt-container ">

						<!-- begin:: Brand -->
						<div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
							<div class="kt-header__brand-logo">
								<a href="index.html">
									<img alt="Logo"
										src="<?= base_url(); ?>/assets/media/logos/logo-5.png" />
								</a>
							</div>
						</div>

						<!-- end:: Brand -->

						<!-- begin:: Header Topbar -->
						<div class="kt-header__topbar">

							<!--begin: Search -->
							<div class="kt-header__topbar-item kt-header__topbar-item--search dropdown kt-hidden-desktop"
								id="kt_quick_search_toggle">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
									<span class="kt-header__topbar-icon kt-header__topbar-icon--success">
										<svg xmlns="http://www.w3.org/2000/svg"
											xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
											viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path
													d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
													fill="#000000" fill-rule="nonzero" opacity="0.3" />
												<path
													d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
													fill="#000000" fill-rule="nonzero" />
											</g>
										</svg>

										<!--<i class="flaticon2-search-1"></i>-->
									</span>
								</div>
								<div
									class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
									<div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact"
										id="kt_quick_search_dropdown">
										<form method="get" class="kt-quick-search__form">
											<div class="input-group">
												<div class="input-group-prepend"><span class="input-group-text"><i
															class="flaticon2-search-1"></i></span></div>
												<input type="text" class="form-control kt-quick-search__input"
													placeholder="Search...">
												<div class="input-group-append"><span class="input-group-text"><i
															class="la la-close kt-quick-search__close"></i></span></div>
											</div>
										</form>
										<div class="kt-quick-search__wrapper kt-scroll" data-scroll="true"
											data-height="325" data-mobile-height="200">
										</div>
									</div>
								</div>
							</div>

							<!--end: Search -->

							<!--begin: User bar -->
							<div class="kt-header__topbar-item kt-header__topbar-item--user">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
									<span class="kt-hidden kt-header__topbar-welcome">Hi,</span>
									<span class="kt-hidden kt-header__topbar-username">Nick</span>
									<img class="kt-hidden-" alt="Pic"
										src="<?php if(isset($profile_picture) && $profile_picture != ""){echo base_url().'/'.$profile_picture;}else{echo base_url(); ?>/assets/media/users/300_21.jpg<?php } ?>" />
									<span
										class="kt-header__topbar-icon kt-header__topbar-icon--brand kt-hidden"><b>S</b></span>
								</div>
								<div
									class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

									<!--begin: Head -->
									<div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
										<div class="kt-user-card__avatar">
											<img class="kt-hidden-" alt="Pic"
												src="<?php if(isset($profile_picture) && $profile_picture != ""){echo base_url().'/'.$profile_picture;}else{echo base_url(); ?>/assets/media/users/300_21.jpg<?php } ?>" />

											<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
											<span
												class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
										</div>
										<div class="kt-user-card__name">
											<?= $first_name; ?>
											<?= $last_name; ?>
										</div>
									</div>

									<!--end: Head -->

									<!--begin: Navigation -->
									<div class="kt-notification">
										<a href="<?php echo base_url(); ?>/user/profile"
											class="kt-notification__item">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-calendar-3 kt-font-success"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													My Profile
												</div>
												<div class="kt-notification__item-time">
													Account settings and more
												</div>
											</div>
										</a>
										<div class="kt-notification__custom kt-space-between">
											<a href="<?= base_url(); ?>/logout"
												class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
										</div>
									</div>

									<!--end: Navigation -->
								</div>
							</div>

							<!--end: User bar -->
						</div>

						<!-- end:: Header Topbar -->
					</div>
				</div>
				<div class="kt-header__bottom">
					<div class="kt-container ">

						<!-- begin: Header Menu -->
						<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
								class="la la-close"></i></button>
						<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
							<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
								<ul class="kt-menu__nav ">
									<li class="kt-menu__item  kt-menu__item--open kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here"
										data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;"
											class="kt-menu__link kt-menu__toggle"><span
												class="kt-menu__link-text">Dashboards</span><i
												class="kt-menu__ver-arrow la la-angle-right"></i></a>
										<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
											<ul class="kt-menu__subnav">
												<li class="kt-menu__item  kt-menu__item--active " aria-haspopup="true">
													<a href="index.html" class="kt-menu__link "><i
															class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
															class="kt-menu__link-text">Default Dashboard</span></a>
												</li>
												<li class="kt-menu__item " aria-haspopup="true"><a
														href="dashboards/fluid.html" class="kt-menu__link "><i
															class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
															class="kt-menu__link-text">Fluid Dashboard</span></a></li>
												<li class="kt-menu__item " aria-haspopup="true"><a
														href="dashboards/aside.html" class="kt-menu__link "><i
															class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
															class="kt-menu__link-text">Aside Dashboard</span></a></li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
							<div class="kt-header-toolbar">
								<div class="kt-quick-search kt-quick-search--inline kt-quick-search--result-compact"
									id="kt_quick_search_inline">
									<form method="get" class="kt-quick-search__form">
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i
														class="flaticon2-search-1"></i></span></div>
											<input type="text" class="form-control kt-quick-search__input"
												placeholder="Search...">
											<div class="input-group-append"><span class="input-group-text"><i
														class="la la-close kt-quick-search__close"
														style="display: none;"></i></span></div>
										</div>
									</form>
									<div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,10px">
									</div>
									<div
										class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
										<div class="kt-quick-search__wrapper kt-scroll" data-scroll="true"
											data-height="300" data-mobile-height="200">
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- end: Header Menu -->
					</div>
				</div>
			</div>

			<!-- end:: Header -->
			<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
				<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

					<!-- begin:: Subheader -->
					<div class="kt-subheader   kt-grid__item" id="kt_subheader">
						<div class="kt-container ">
						</div>
					</div>

					<!-- end:: Subheader -->

					<!-- begin:: Content -->
					<div class="kt-container  kt-grid__item kt-grid__item--fluid">

						<!--Begin::Dashboard 3-->

						<!--Begin::Row-->
						<div class="row">
							<div class="col-lg-4 col-xl-4 order-lg-1 order-xl-1">
								<!--begin:: Widgets/Trends-->
								<div class="kt-portlet kt-portlet--head--noborder kt-portlet--height-fluid">
									<div class="kt-portlet__head kt-portlet__head--noborder">
										<div class="kt-portlet__head-label">
											<h3 class="kt-portlet__head-title">
												Create New Project
											</h3>
										</div>
									</div>
									<div class="kt-portlet__body kt-portlet__body--fluid kt-portlet__body--fit">
										<div class="kt-grid  kt-wizard-v2 kt-wizard-v2--white">
											<div class="kt-grid__item kt-wizard-v2__aside">

												<!--begin: Form Wizard Nav -->
												<div class="kt-wizard-v2__nav">
													<div
														class="kt-wizard-v2__nav-items kt-wizard-v2__nav-items--clickable">

														<!--doc: Replace A tag with SPAN tag to disable the step link click -->
														<!-- data-ktwizard-state="current" -->
														<div class="kt-wizard-v2__nav-item"
															data-ktwizard-type="usernameScrap">
															<div class="kt-wizard-v2__nav-body">
																<div class="kt-wizard-v2__nav-icon">
																	<i class="fa fa-at"></i>
																</div>
																<div class="kt-wizard-v2__nav-label">
																	<div class="kt-wizard-v2__nav-label-title">
																		Scraping Username Data
																	</div>
																	<div class="kt-wizard-v2__nav-label-desc">
																		Followers, followings, posts, comments
																	</div>
																</div>
															</div>
														</div>
														<div class="kt-wizard-v2__nav-item"
															data-ktwizard-type="hashtagScrap">
															<div class="kt-wizard-v2__nav-body">
																<div class="kt-wizard-v2__nav-icon">
																	<i class="fa fa-hashtag"></i>
																</div>
																<div class="kt-wizard-v2__nav-label">
																	<div class="kt-wizard-v2__nav-label-title">
																		Scraping Hashtag Data
																	</div>
																	<div class="kt-wizard-v2__nav-label-desc">
																		Likes, Comments and Posts
																	</div>
																</div>
															</div>
														</div>
														<div class="kt-wizard-v2__nav-item"
															data-ktwizard-type="locationScrap">
															<div class="kt-wizard-v2__nav-body">
																<div class="kt-wizard-v2__nav-icon">
																	<i class="fa fa-map-marker-alt"></i>
																</div>
																<div class="kt-wizard-v2__nav-label">
																	<div class="kt-wizard-v2__nav-label-title">
																		Scraping Location Data
																	</div>
																	<div class="kt-wizard-v2__nav-label-desc">
																		Likes, Comments and Posts
																	</div>
																</div>
															</div>
														</div>
														<div class="kt-wizard-v2__nav-item"
															data-ktwizard-type="postScrap">
															<div class="kt-wizard-v2__nav-body">
																<div class="kt-wizard-v2__nav-icon">
																	<i class="fa fa-file"></i>
																</div>
																<div class="kt-wizard-v2__nav-label">
																	<div class="kt-wizard-v2__nav-label-title">
																		Scraping Post Data
																	</div>
																	<div class="kt-wizard-v2__nav-label-desc">
																		Likes and Comments
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<!--end: Form Wizard Nav -->
											</div>
										</div>
									</div>
								</div>
								<!--end:: Widgets/Trends-->
							</div>
							<div class="col-lg-4 col-xl-4 order-lg-1 order-xl-1">
								<div class="kt-portlet kt-portlet--height-fluid">
									<div class="kt-portlet__head">
										<div class="kt-portlet__head-label">
											<h3 class="kt-portlet__head-title">
												Create New Order
											</h3>
										</div>
									</div>
									<form id="createOrderForm" class="kt-form">
										<input type="hidden" id="txId" name="transaction_id" />
										<div class="kt-portlet__body">
											<div class="form-group">
												<label>Select Plan</label>
												<select id="selectedPlan" class="form-control" name="selected_plan">
													<option value="0|0">FREE - 100 ( 0$ )</option>
													<?php foreach ($Plans as $Plan): ?>
													<option
														value="<?= $Plan['id']; ?>|<?= $Plan['plan_price']; ?>">
														<?= $Plan['plan_title'] . " - " . $Plan['plan_credits'] . " ( $" . $Plan['plan_price'] . " )"; ?>
													</option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="form-group">
												<label>Payment Method</label>
												<select id="paymentMethod" class="form-control" name="payment_method">
													<option value="paypal">Paypal</option>
													<option value="btc">BitCoin</option>
												</select>
											</div>
											<div class="form-group">
												<label>Discount</label>
												<input type="text" name="discount_code" id="applyDiscount"
													class="form-control" />
											</div>
										</div>
										<div class="kt-portlet__foot">
											<div class="kt-form__actions">
												<button type="button" id="createOrder"
													class="btn btn-primary">Create</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 order-lg-1 order-xl-1">
								<!--begin:: Widgets/Finance Summary-->
								<div class="kt-portlet kt-portlet--height-fluid">
									<div class="kt-portlet__head">
										<div class="kt-portlet__head-label">
											<h3 class="kt-portlet__head-title">
												Statistics
											</h3>
										</div>
									</div>
									<div class="kt-portlet__body">
										<div class="kt-widget12">
											<div class="kt-widget12__content">
												<div class="kt-widget12__item">
													<div class="kt-widget12__info">
														<span class="kt-widget12__desc">Total Credits</span>
														<span class="kt-widget12__value"><?= $statistics['total_credits']; ?></span>
													</div>
													<div class="kt-widget12__info">
														<span class="kt-widget12__desc">Last Topup Date</span>
														<span class="kt-widget12__value">July 24,2017</span>
													</div>
												</div>
												<div class="kt-widget12__item">
													<div class="kt-widget12__info">
														<span class="kt-widget12__desc">Avarage Cost per lead</span>
														<span class="kt-widget12__value">$60,70</span>
													</div>
													<div class="kt-widget12__info">
														<span class="kt-widget12__desc">Lead Conversion Rate</span>
														<span class="kt-widget12__progress">
															<div class="progress progress-sm">
																<div class="progress-bar kt-bg-brand" role="progressbar"
																	style="width: 63%" aria-valuenow="63"
																	aria-valuemin="0" aria-valuemax="100"></div>
															</div>
															<span class="kt-widget12__stat">
																63%
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--end:: Widgets/Finance Summary-->
							</div>
							<div class="col-xl-12 col-lg-12 order-lg-3 order-xl-1">

								<!--begin:: Widgets/User Progress -->
								<div class="kt-portlet kt-portlet--height-fluid">
									<div class="kt-portlet__head">
										<div class="kt-portlet__head-label">
											<h3 class="kt-portlet__head-title">
												User Progress
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											<ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold"
												role="tablist">
												<li class="nav-item">
													<a class="nav-link active" data-toggle="tab"
														href="#kt_widget31_tab1_content" role="tab">
														Today
													</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab"
														href="#kt_widget31_tab2_content" role="tab">
														Week
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="kt-portlet__body kt-portlet__body--fit">
										<!--begin: Datatable -->
										<div class="kt-datatable" id="kt_datatable-tasks"></div>
										<!--end: Datatable -->
									</div>
								</div>

								<!--end:: Widgets/User Progress -->
							</div>
						</div>

						<!--End::Row-->

						<!--End::Dashboard 3-->
					</div>

					<!-- end:: Content -->
				</div>
			</div>




			<!--Begin:: Modals-->
			<!--Begin:: Scrap Modals -->
			<div id="usernameScrap" class="modal fade scrap-modal_reset" tabindex="-1" role="dialog"
				aria-labelledby="usernameScrapLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Create New Project</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="kt_wizard_v3"
								data-ktwizard-state="step-first">
								<div class="kt-grid__item">

									<!--begin: Form Wizard Nav -->
									<div class="kt-wizard-v3__nav">
										<div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
											<!--doc: Replace A tag with SPAN tag to disable the step link click -->
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step"
												data-ktwizard-state="current">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>1</span> Setup Target Username
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>2</span> Setup Scraping options
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>3</span> Complete
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
										</div>
									</div>

									<!--end: Form Wizard Nav -->
								</div>
								<div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3__wrapper">

									<!--begin: Form Wizard Form-->
									<form action="/rest/user/task/create" class="kt-form" id="kt_form" method="POST">
										<input type="hidden" name="task_type" value="username" />
										<input type="hidden" name="task_max" id="taskMaxTarget" />
										<!--begin: Form Wizard Step 1-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
											data-ktwizard-state="current">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Instagram Username</label>
														<div class="typeahead">
															<input type="text" class="form-control"
																id="instaUsernameUScrap" dir="ltr"
																placeholder="Username">
															<input type="hidden" id="instaUsernameIdUScrap"
																name="task_destination" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 1-->

										<!--begin: Form Wizard Step 2-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Project Name</label>
														<input type="text" class="form-control" name="task_name"
															placeholder="Project Name" />
													</div>
													<div class="row">
														<div class="col-12">
															<label>Scraping Type</label>
														</div>
														<div class="col-6 border-right">
															<div class="form-group row">
																<label class="col-6 col-form-label">Scrap
																	Followers</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox"
																				name="username_followers"
																				data-scrap="followers"
																				class="kt-switch_scraping_type-username">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden"
																			name="username_followers_max"
																			class="total_scraps total_scraps-followers" />
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-6 col-form-label">Scrap Posts</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="username_posts"
																				data-scrap="posts"
																				class="kt-switch_scraping_type-username">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="username_posts_max"
																			class="total_scraps total_scraps-posts" />
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-6 col-form-label">Scrap
																	Comments</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox"
																				name="username_comments"
																				data-scrap="comments"
																				class="kt-switch_scraping_type-username">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden"
																			name="username_comments_max"
																			class="total_scraps total_scraps-comments" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-6">
															<div class="form-group row">
																<label class="col-6 col-form-label">Scrap
																	Followings</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox"
																				name="username_followings"
																				data-scrap="followings"
																				class="kt-switch_scraping_type-username">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden"
																			name="username_followings_max"
																			class="total_scraps total_scraps-followings" />
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-6 col-form-label">Scrap Likes</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="username_likes"
																				data-scrap="likes"
																				class="kt-switch_scraping_type-username">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="username_likes_max"
																			class="total_scraps total_scraps-likes" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 2-->

										<!--begin: Form Wizard Step 3-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-heading kt-heading--md">Order Resume</div>
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-portlet__body">
													<div class="kt-widget6">
														<div class="kt-widget6__body">
															<div class="kt-widget6__item">
																<span>Username</span>
																<span id="instaUsernameUScrapTarget"
																	class="kt-font-brand kt-font-bold"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Scrap Types</span>
																<span class="kt-font-brand kt-font-bold"
																	id="scrapTypesTarget"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Total Credits</span>
																<span class="kt-font-brand kt-font-bold"
																	id="totalCreditsTarget"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 3-->

										<!--begin: Form Actions -->
										<div class="kt-form__actions kt-align-right">
											<button
												class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-prev">
												Previous
											</button>
											<button
												class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-submit">
												Submit
											</button>
											<button
												class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-next">
												Next Step
											</button>
										</div>
									</form>

									<!--end: Form Wizard Form-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="hashtagScrap" class="modal fade scrap-modal_reset" tabindex="-1" role="dialog"
				aria-labelledby="hashtagScrapLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="hashtagScrapLabel">Create New Project</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="hashtagWizard"
								data-ktwizard-state="step-first">
								<div class="kt-grid__item">

									<!--begin: Form Wizard Nav -->
									<div class="kt-wizard-v3__nav">
										<div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
											<!--doc: Replace A tag with SPAN tag to disable the step link click -->
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step"
												data-ktwizard-state="current">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>1</span> Setup Target Hashtag
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>2</span> Setup Scraping options
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>3</span> Complete
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
										</div>
									</div>

									<!--end: Form Wizard Nav -->
								</div>
								<div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3__wrapper">

									<!--begin: Form Wizard Form-->
									<form action="/rest/user/task/create" class="kt-form" id="kt_form-hashtag"
										method="POST">
										<input type="hidden" name="task_type" value="hashtag" />
										<input type="hidden" name="task_max" id="hashtagTaskMaxTarget" />
										<!--begin: Form Wizard Step 1-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
											data-ktwizard-state="current">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Instagram Hashtag</label>
														<div class="typeahead">
															<input type="text" class="form-control"
																id="instaHashtagUScrap" name="task_destination"
																dir="ltr" placeholder="Hashtag">
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 1-->

										<!--begin: Form Wizard Step 2-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Project Name</label>
														<input type="text" class="form-control" name="task_name"
															placeholder="Project Name" />
													</div>
													<div class="row">
														<div class="col-12">
															<label>Scraping Type</label>
														</div>
														<div class="col-6 border-right">
															<div class="form-group row">
																<label class="col-6 col-form-label">Hashtag
																	Likes</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="hashtag_likes"
																				data-scrap="likes"
																				class="kt-switch_scraping_type-hashtag">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="hashtag_likes_max"
																			class="total_scraps total_scraps-hashtag-likes" />
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-6 col-form-label">Hashtag
																	Posts</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="hashtag_posts"
																				data-scrap="posts"
																				class="kt-switch_scraping_type-hashtag">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="hashtag_posts_max"
																			class="total_scraps total_scraps-hashtag-posts" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-6">
															<div class="form-group row">
																<label class="col-6 col-form-label">Hashtag
																	Comments</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox"
																				name="hashtag_comments"
																				data-scrap="comments"
																				class="kt-switch_scraping_type-hashtag">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="hashtag_comments_max"
																			class="total_scraps total_scraps-hashtag-comments" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 2-->

										<!--begin: Form Wizard Step 3-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-heading kt-heading--md">Order Resume</div>
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-portlet__body">
													<div class="kt-widget6">
														<div class="kt-widget6__body">
															<div class="kt-widget6__item">
																<span>Hashtag</span>
																<span id="instaHashtagUScrapTarget"
																	class="kt-font-brand kt-font-bold"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Scrap Types</span>
																<span class="kt-font-brand kt-font-bold"
																	id="hashtagScrapTypesTarget"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Total Credits</span>
																<span class="kt-font-brand kt-font-bold"
																	id="hashtagTotalCreditsTarget"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 3-->

										<!--begin: Form Actions -->
										<div class="kt-form__actions kt-align-right">
											<button
												class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-prev">
												Previous
											</button>
											<button
												class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-submit">
												Submit
											</button>
											<button
												class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-next">
												Next Step
											</button>
										</div>
									</form>

									<!--end: Form Wizard Form-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="locationScrap" class="modal fade scrap-modal_reset" tabindex="-1" role="dialog"
				aria-labelledby="locationScrapLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="locationScrapLabel">Create New Project</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="locationWizard"
								data-ktwizard-state="step-first">
								<div class="kt-grid__item">

									<!--begin: Form Wizard Nav -->
									<div class="kt-wizard-v3__nav">
										<div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
											<!--doc: Replace A tag with SPAN tag to disable the step link click -->
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step"
												data-ktwizard-state="current">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>1</span> Setup Target Location
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>2</span> Setup Scraping options
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>3</span> Complete
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
										</div>
									</div>

									<!--end: Form Wizard Nav -->
								</div>
								<div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3__wrapper">

									<!--begin: Form Wizard Form-->
									<form action="/rest/user/task/create" class="kt-form" id="kt_form-location"
										method="POST">
										<input type="hidden" name="task_type" value="location" />
										<input type="hidden" name="task_max" id="locationTaskMaxTarget" />
										<!--begin: Form Wizard Step 1-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
											data-ktwizard-state="current">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Instagram Location</label>
														<div class="typeahead">
															<input type="text" class="form-control"
																id="instaLocationUScrap" dir="ltr"
																name="insta_location_step" placeholder="Hashtag">
															<input type="hidden" id="instaLocationIdUScrap"
																name="task_destination" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 1-->

										<!--begin: Form Wizard Step 2-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Project Name</label>
														<input type="text" class="form-control" name="task_name"
															placeholder="Project Name" />
													</div>
													<div class="row">
														<div class="col-12">
															<label>Scraping Type</label>
														</div>
														<div class="col-6 border-right">
															<div class="form-group row">
																<label class="col-6 col-form-label">Location
																	Likes</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="location_likes"
																				data-scrap="likes"
																				class="kt-switch_scraping_type-location">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="location_likes_max"
																			class="total_scraps total_scraps-location-likes" />
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-6 col-form-label">Location
																	Posts</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="location_posts"
																				data-scrap="posts"
																				class="kt-switch_scraping_type-location">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="location_posts_max"
																			class="total_scraps total_scraps-location-posts" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-6">
															<div class="form-group row">
																<label class="col-6 col-form-label">Location
																	Comments</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox"
																				name="location_comments"
																				data-scrap="comments"
																				class="kt-switch_scraping_type-location">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden"
																			name="location_comments_max"
																			class="total_scraps total_scraps-location-comments" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 2-->

										<!--begin: Form Wizard Step 3-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-heading kt-heading--md">Order Resume</div>
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-portlet__body">
													<div class="kt-widget6">
														<div class="kt-widget6__body">
															<div class="kt-widget6__item">
																<span>Location</span>
																<span id="instaLocationUScrapTarget"
																	class="kt-font-brand kt-font-bold"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Scrap Types</span>
																<span class="kt-font-brand kt-font-bold"
																	id="locationScrapTypesTarget"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Total Credits</span>
																<span class="kt-font-brand kt-font-bold"
																	id="locationTotalCreditsTarget"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 3-->

										<!--begin: Form Actions -->
										<div class="kt-form__actions kt-align-right">
											<button
												class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-prev">
												Previous
											</button>
											<button
												class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-submit">
												Submit
											</button>
											<button
												class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-next">
												Next Step
											</button>
										</div>
									</form>

									<!--end: Form Wizard Form-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="postScrap" class="modal fade scrap-modal_reset" tabindex="-1" role="dialog"
				aria-labelledby="postScrapLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="postScrapLabel">Create New Project</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="postWizard"
								data-ktwizard-state="step-first">
								<div class="kt-grid__item">

									<!--begin: Form Wizard Nav -->
									<div class="kt-wizard-v3__nav">
										<div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
											<!--doc: Replace A tag with SPAN tag to disable the step link click -->
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step"
												data-ktwizard-state="current">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>1</span> Setup Target Post
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>2</span> Setup Scraping options
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
											<div class="kt-wizard-v3__nav-item" data-ktwizard-type="step">
												<div class="kt-wizard-v3__nav-body">
													<div class="kt-wizard-v3__nav-label">
														<span>3</span> Complete
													</div>
													<div class="kt-wizard-v3__nav-bar"></div>
												</div>
											</div>
										</div>
									</div>

									<!--end: Form Wizard Nav -->
								</div>
								<div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3__wrapper">

									<!--begin: Form Wizard Form-->
									<form action="/rest/user/task/create" class="kt-form" id="kt_form-post"
										method="POST">
										<input type="hidden" name="task_type" value="post" />
										<input type="hidden" name="task_max" id="postTaskMaxTarget" />
										<!--begin: Form Wizard Step 1-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
											data-ktwizard-state="current">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Instagram Post</label>
														<div class="typeahead">
															<input type="text" class="form-control" id="instaPostUScrap"
																name="insta_post_step" dir="ltr"
																placeholder="Post Link">
															<input type="hidden" id="instaPostIdUScrap"
																name="task_destination" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 1-->

										<!--begin: Form Wizard Step 2-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-wizard-v3__form">
													<div class="form-group">
														<label>Project Name</label>
														<input type="text" class="form-control" name="task_name"
															placeholder="Project Name" />
													</div>
													<div class="row">
														<div class="col-12">
															<label>Scraping Type</label>
														</div>
														<div class="col-6 border-right">
															<div class="form-group row">
																<label class="col-6 col-form-label">Post Likes</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="post_likes"
																				data-scrap="likes"
																				class="kt-switch_scraping_type-post">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="post_likes_max"
																			class="total_scraps total_scraps-post-likes" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-6">
															<div class="form-group row">
																<label class="col-6 col-form-label">Post
																	Comments</label>
																<div class="col-6 kt-align-right">
																	<span class="kt-switch kt-switch--icon">
																		<label>
																			<input type="checkbox" name="post_comments"
																				data-scrap="comments"
																				class="kt-switch_scraping_type-post">
																			<span></span>
																		</label>
																	</span>
																</div>
																<div class="col-12 kt-total_scraps">
																	<div class="kt-ion-range-slider">
																		<input type="hidden" name="post_comments_max"
																			class="total_scraps total_scraps-post-comments" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 2-->

										<!--begin: Form Wizard Step 3-->
										<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
											<div class="kt-heading kt-heading--md">Order Resume</div>
											<div class="kt-form__section kt-form__section--first">
												<div class="kt-portlet__body">
													<div class="kt-widget6">
														<div class="kt-widget6__body">
															<div class="kt-widget6__item">
																<span>Post</span>
																<span id="instaPostUScrapTarget"
																	class="kt-font-brand kt-font-bold"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Scrap Types</span>
																<span class="kt-font-brand kt-font-bold"
																	id="postScrapTypesTarget"></span>
															</div>
															<div class="kt-widget6__item">
																<span>Total Credits</span>
																<span class="kt-font-brand kt-font-bold"
																	id="postTotalCreditsTarget"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 3-->

										<!--begin: Form Actions -->
										<div class="kt-form__actions kt-align-right">
											<button
												class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-prev">
												Previous
											</button>
											<button
												class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-submit">
												Submit
											</button>
											<button
												class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
												data-ktwizard-type="action-next">
												Next Step
											</button>
										</div>
									</form>

									<!--end: Form Wizard Form-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Begin:: Tasks Modals -->
			<div id="loadChildTasks" class="modal fade" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content" style="min-height: 590px;">
						<div class="modal-header">
							<h5 class="modal-title">
								Project Details
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body modal-body-fit">
							<!--begin: Datatable -->
							<div id="modal_datatable_child_tasks"></div>
							<!--end: Datatable -->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-clean btn-bold btn-upper btn-font-sm"
								data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div id="loadTaskDetails" class="modal fade" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content" style="min-height: 590px;">
						<div class="modal-header">
							<h5 class="modal-title">
								Task Details
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body modal-body-fit">
							<!--begin: Datatable -->
							<table class="table table-striped- table-bordered table-hover table-checkable"
								id="modal_datatable_task_details">
							</table>
							<!--end: Datatable -->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-clean btn-bold btn-upper btn-font-sm"
								data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div id="confirmPaymentModal" class="modal fade" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">
								Confirm Your Order
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body modal-body-fit">
							<div class="kt-widget13">
								<div class="kt-widget13__item">
									<span class="kt-widget13__desc">Total</span>
									<span id="orderPrice" class="kt-widget13__text kt-widget13__text--bold">
										0$
									</span>
								</div>
								<div class="kt-widget13__item">
									<span class="kt-widget13__desc">Payment Method</span>
									<span id="orderPaymentMethod" class="kt-widget13__text kt-widget13__text--bold">
										PayPal
									</span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" id="confirmCreateOrder"
								class="btn btn-brand btn-bold btn-upper btn-font-sm">Confirm</button>
							<button type="button" class="btn btn-clean btn-bold btn-upper btn-font-sm"
								data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--ENd:: Modals-->
			<div id="confirm-paypal-payment" class="modal fade" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">
								Confirm Your Order
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body modal-body-fit">
							<input type="hidden" name="paypalpay" id="paypalpay" />
							<div class="kt-widget13">
								<div class="kt-widget13__item">
									<span class="kt-widget13__desc">Total</span>
									<span id="paypalPrice" class="kt-widget13__text kt-widget13__text--bold">
										0$
									</span>
								</div>
								<div class="kt-widget13__item">
									<span class="kt-widget13__desc">Payment Method</span>
									<span id="orderPaymentMethod" class="kt-widget13__text kt-widget13__text--bold">
										PayPal
									</span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" id="confirmPaypalOrder"
								class="btn btn-brand btn-bold btn-upper btn-font-sm"><i
									class="icon-xl fab fa-paypal"></i> Pay </button>
							<button type="button" class="btn btn-clean btn-bold btn-upper btn-font-sm"
								data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>