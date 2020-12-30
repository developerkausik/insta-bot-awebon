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
												Discounts Management
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											<div class="kt-portlet__head-wrapper">
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#newDiscount">
														<i class="flaticon2-plus"></i> New Discount
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
										<div class="kt-datatable" id="discountsDatatable"></div>
										<!--end: Datatable -->
									</div>
								</div>
							</div>

							<!-- end:: Content -->
						</div>
					</div>

                    <!--begin::Modals-->
                    <div class="modal fade" id="newDiscount" tabindex="-1" role="dialog" aria-labelledby="newDiscountLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newDiscountLabel">New Discount</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="newDiscountForm" action="<?=base_url()?>/rest/admin/discounts/create" method="POST">
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Discount Name</label>
                                            <input type="text" class="form-control" name="discount_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Discount Type</label>
                                            <select class="form-control" name="discount_type">
                                                <option value="0">Percentage</option>
                                                <option value="1">Amount</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Discount Value</label>
                                            <input type="text" class="form-control" name="discount_amount">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Discount Code</label>
                                            <input type="text" class="form-control" name="discount_code">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Discount Status</label>
                                            <input type="hidden" name="discount_status" value="off" />
                                            <div class="col-12 kt-align-left">
                                                <span class="kt-switch">
                                                    <label>
                                                        <input id="createDiscountStatus" type="checkbox" name="discount_status">
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="createNewDiscount" class="btn btn-brand">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteDiscount" tabindex="-1" role="dialog" aria-labelledby="deleteDiscountLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteDiscountLabel">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deleteDiscountForm" action="<?=base_url()?>/rest/admin/teams/delete" method="POST">
                                        <input type="hidden" name="discount_id" id="discountDeleteID" />
                                        <p>Please Confirm the deletion of the following Discount : <span id="discountDeleteName" style="font-weight: bold;"></span></p>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="confirmDeleteDiscount" class="btn btn-brand">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editDiscount" tabindex="-1" role="dialog" aria-labelledby="editDiscountLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDiscountLabel">Edit Discount</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editDiscountForm" action="<?=base_url()?>/rest/admin/plans/edit" method="POST">
                                        <input type="hidden" name="discount_id" id="discountEditID" />
                                        <div class="form-group">
                                            <label for="discountEditName" class="form-control-label">Discount Name</label>
                                            <input type="text" id="discountEditName" class="form-control" name="discount_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="discountEditType" class="form-control-label">Discount Type</label>
                                            <select id="discountEditType" class="form-control" name="discount_type">
                                                <option value="0">Percentage</option>
                                                <option value="1">Amount</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="discountEditAmount" class="form-control-label">Discount Value</label>
                                            <input type="text" id="discountEditAmount" class="form-control" name="discount_amount">
                                        </div>
                                        <div class="form-group">
                                            <label for="discountEditCode" class="form-control-label">Discount Code</label>
                                            <input type="text" id="discountEditCode" class="form-control" name="discount_code">
                                        </div>
                                        <div class="form-group">
                                            <label for="discountEditStatus" class="form-control-label">Discount Status</label>
                                            <input type="hidden" name="discount_status" value="off" />
                                            <div class="col-12 kt-align-left">
                                                <span class="kt-switch">
                                                    <label>
                                                        <input id="discountEditStatus" type="checkbox" name="discount_status">
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="confirmEditDiscount" class="btn btn-brand">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->