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
												Plans Management
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											<div class="kt-portlet__head-wrapper">
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#newPlan">
														<i class="flaticon2-plus"></i> New Plan
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
										<div class="kt-datatable" id="plansDatatable"></div>
										<!--end: Datatable -->
									</div>
								</div>
							</div>

							<!-- end:: Content -->
						</div>
					</div>

                    <!--begin::Modals-->
                    <div class="modal fade" id="newPlan" tabindex="-1" role="dialog" aria-labelledby="newPlanLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newPlanLabel">New Plan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="newPlanForm" action="<?=base_url()?>/rest/admin/plans/create" method="POST">
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Plan Title</label>
                                            <input type="text" class="form-control" name="plan_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Plan Description</label>
                                            <textarea class="form-control" name="plan_description" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Plan Price</label>
                                            <input type="text" class="form-control" name="plan_price">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Plan Credits</label>
                                            <input type="text" class="form-control" name="plan_credits">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="createNewPlan" class="btn btn-brand">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deletePlan" tabindex="-1" role="dialog" aria-labelledby="deletePlanLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deletePlanForm" action="<?=base_url()?>/rest/admin/teams/delete" method="POST">
                                        <input type="hidden" name="plan_id" id="planDeleteID" />
                                        <p>Please Confirm the deletion of the following Plan : <span id="planDeleteName" style="font-weight: bold;"></span></p>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="confirmDeletePlan" class="btn btn-brand">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editPlan" tabindex="-1" role="dialog" aria-labelledby="editPlanLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editTeamLabel">Edit Plan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editPlanForm" action="<?=base_url()?>/rest/admin/plans/edit" method="POST">
                                        <input type="hidden" name="plan_id" id="planEditID" />
                                        <div class="form-group">
                                            <label for="planEditName" class="form-control-label">Plan Title</label>
                                            <input type="text" class="form-control" name="plan_title" id="planEditName">
                                        </div>
                                        <div class="form-group">
                                            <label for="planEditDescription" class="form-control-label">Plan Description</label>
                                            <textarea class="form-control" name="plan_description" rows="5" id="planEditDescription"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="planEditPrice" class="form-control-label">Plan Price</label>
                                            <input type="text" class="form-control" name="plan_price" id="planEditPrice">
                                        </div>
                                        <div class="form-group">
                                            <label for="planEditCredits" class="form-control-label">Plan Credits</label>
                                            <input type="text" class="form-control" name="plan_credits" id="planEditCredits">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="confirmEditPlan" class="btn btn-brand">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->