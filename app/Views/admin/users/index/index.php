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
												System User
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											<div class="kt-portlet__head-wrapper">
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#newUser">
														<i class="flaticon2-plus"></i> New User
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
																	<label>Type:</label>
																</div>
																<div class="kt-form__control">
																	<select class="form-control bootstrap-select" id="kt_form_user-type">
																		<option value="">All</option>
																		<option value="1">User</option>
																		<option value="2">Administrator</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
															<div class="kt-form__group kt-form__group--inline">
																<div class="kt-form__label">
																	<label>Status:</label>
																</div>
																<div class="kt-form__control">
																	<select class="form-control bootstrap-select" id="kt_form_user-status">
																		<option value="">All</option>
																		<option value="0">Active</option>
																		<option value="1">Banned</option>
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
										<div class="kt-datatable" id="usersDatatable"></div>
										<!--end: Datatable -->
									</div>
								</div>
							</div>

							<!-- end:: Content -->
						</div>
					</div>

                    <!--begin::Modals-->
                    <div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="newUserLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newUserLabel">New User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="newUserForm" action="<?=base_url()?>/rest/admin/users/create" method="POST">
                                        <div class="form-group">
                                            <label for="" class="form-control-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">User Type</label>
                                            <select class="form-control" name="account_type">
                                                <option value="1">User</option>
                                                <option value="2">Administrator</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">User Plan</label>
                                            <select class="form-control" name="user_plan">
                                                <option value="0">Free</option>
                                                <?php foreach($UserPlans as $Plan): ?>
                                                <option value="<?= $Plan['id']; ?>"><?= $Plan['plan_title']; ?> - <?= $Plan['plan_credits']; ?> Credits</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="createNewUser" class="btn btn-brand">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteUserLabel">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deleteUserForm" action="<?=base_url()?>/rest/admin/users/delete" method="POST">
                                        <input type="hidden" name="user_id" id="userDeleteID" />
                                        <p>Please Confirm the deletion of the following User : <span id="userDeleteName" style="font-weight: bold;"></span></p>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="confirmDeleteUser" class="btn btn-brand">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editUserForm" action="<?=base_url()?>/rest/admin/users/edit" method="POST">
                                        <input type="hidden" name="user_id" id="userEditID" />
                                        <div class="form-group">
                                            <label for="userEditFirstName" class="form-control-label">First Name</label>
                                            <input type="text" class="form-control" id="userEditFirstName" name="first_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="userEditLastName" class="form-control-label">Last Name</label>
                                            <input type="text" class="form-control" id="userEditLastName" name="last_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="userEditEmail" class="form-control-label">Email</label>
                                            <input type="email" class="form-control" id="userEditEmail" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password">
                                        </div>
                                        <div class="form-group">
                                            <label for="userEditAccountType" class="form-control-label">User Type</label>
                                            <select class="form-control" id="userEditAccountType" name="account_type">
                                                <option value="1">User</option>
                                                <option value="2">Administrator</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="userEditUserStatus" class="form-control-label">User Status</label>
                                            <select class="form-control" id="userEditUserStatus" name="user_status">
                                                <option value="0">Active</option>
                                                <option value="1">Banned</option>
                                            </select>
                                        </div>
                                        <div class="form-group user-ban_reason kt-hidden">
                                            <label for="userEditUserBanReason" class="form-control-label">Ban Reason</label>
                                            <textarea class="form-control" name="user_ban_reason" id="userEditUserBanReason" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="userEditUserCredits" class="form-control-label">Credits</label>
                                            <input type="text" class="form-control" id="userEditUserCredits" name="user_credits">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="confirmEditUser" class="btn btn-brand">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->