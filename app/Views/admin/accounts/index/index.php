                    <?= view("template/admin_menu"); ?>

					<!-- end:: Header -->
					<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
						<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

							<!-- begin:: Subheader -->
							<div class="kt-subheader   kt-grid__item" id="kt_subheader">
							</div>

							<!-- end:: Subheader -->

							<!-- begin:: Content -->
							<div class="kt-container  kt-grid__item kt-grid__item--fluid">
								<div class="kt-portlet kt-portlet--mobile">
									<div class="kt-portlet__head kt-portlet__head--lg">
										<div class="kt-portlet__head-label">
											<span class="kt-portlet__head-icon">
												<i class="kt-font-brand flaticon2-line-chart"></i>
											</span>
											<h3 class="kt-portlet__head-title">
												Instagram Accounts
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											<div class="kt-portlet__head-wrapper">
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#uploadCsvModal">
														<i class="flaticon2-plus"></i> Import Accounts
													</button>
												</div>
											</div>
										</div>
									</div>
									<div class="kt-portlet__body">

										<!--begin: Search Form -->
										<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
											<div class="row align-items-center">
												<div class="col-xl-8 order-2 order-xl-1">
													<div class="row align-items-center">
														<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
															<div class="kt-input-icon kt-input-icon--left">
																<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
																<span class="kt-input-icon__icon kt-input-icon__icon--left">
																	<span><i class="la la-search"></i></span>
																</span>
															</div>
														</div>
														<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
															<div class="kt-form__group kt-form__group--inline">
																<div class="kt-form__label">
																	<label>Status:</label>
																</div>
																<div class="kt-form__control">
																	<select class="form-control bootstrap-select" id="kt_form_status">
																		<option value="">All</option>
																		<option value="1">Pending</option>
																		<option value="2">Delivered</option>
																		<option value="3">Canceled</option>
																		<option value="4">Success</option>
																		<option value="5">Info</option>
																		<option value="6">Danger</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
															<div class="kt-form__group kt-form__group--inline">
																<div class="kt-form__label">
																	<label>Type:</label>
																</div>
																<div class="kt-form__control">
																	<select class="form-control bootstrap-select" id="kt_form_type">
																		<option value="">All</option>
																		<option value="1">Online</option>
																		<option value="2">Retail</option>
																		<option value="3">Direct</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-xl-4 order-1 order-xl-2 kt-align-right">
													<a href="#" class="btn btn-default kt-hidden">
														<i class="la la-cart-plus"></i> New Order
													</a>
													<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
												</div>
											</div>
										</div>

										<!--end: Search Form -->
									</div>
									<div class="kt-portlet__body kt-portlet__body--fit">

										<!--begin: Datatable -->
										<div class="kt-datatable" id="ajax_data"></div>

										<!--end: Datatable -->
									</div>
								</div>
							</div>

							<!-- end:: Content -->
						</div>
					</div>


                    <!--Begin:: Modals-->
                    <div id="uploadCsvModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadCsvModalLabel">Import File</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="kt-portlet kt-portlet--height-fluid">
                                        <div class="kt-portlet__body">
                                            <div class="kt-uppy" id="kt_uppy_3">
                                                <div class="kt-uppy__drag"></div>
                                                <div class="kt-uppy__informer"></div>
                                                <div class="kt-uppy__progress"></div>
                                                <div class="kt-uppy__thumbnails"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="verifyAccount" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="verifyAccountLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="<?=base_url()?>/rest/admin/accounts/verify" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="verifyAccountLabel">Verify Account</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="selectedAccoundId" name="account_id" />
                                        <div class="form-group">
                                            <label>Captcha Verification</label>
                                            <input type="text" name="captcha_verification" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <button type="button" id="verifyIgAccount" class="btn btn-brand">Verify</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>