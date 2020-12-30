                    <?= view("template/admin_menu"); ?>

					<!-- end:: Header -->
                    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                            <!-- begin:: Subheader -->
                            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                                <div class="kt-container ">
                                    <div class="kt-subheader__main">
                                        <h3 class="kt-subheader__title">
                                            Dashboard </h3>
                                    </div>
                                </div>
                            </div>

                            <!-- end:: Subheader -->

                            <!-- begin:: Content -->
                            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                                <div class="kt-portlet ">
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--user-profile-3">
                                            <div class="kt-widget__bottom">
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="flaticon-piggy-bank"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">Total Earnings</span>
                                                        <span class="kt-widget__value"><span>$</span><?= $TotalEarning; ?></span>
                                                    </div>
                                                </div>
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="flaticon-confetti"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">Total Orders</span>
                                                        <span class="kt-widget__value"><?= $TotalOrders; ?></span>
                                                    </div>
                                                </div>
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="flaticon-network"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">Total Members</span>
                                                        <span class="kt-widget__value"><?= $TotalMembers; ?></span>
                                                    </div>
                                                </div>
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="flaticon-file-2"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">Total Tasks</span>
                                                        <span class="kt-widget__value"><?= $TotalTasks; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">

                                        <!--begin:: Widgets/Order Statistics-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Order Statistics
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class='input-group pull-right' id='filterStatistics'>
                                                        <input type='text' class="form-control" readonly placeholder="Select date range" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body kt-portlet__body--fluid">
                                                <div class="kt-widget12">
                                                    <div class="kt-widget12__chart" style="height:250px;">
                                                        <canvas id="kt_chart_order_statistics"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Order Statistics-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        Paypal Orders vs. Bitcoin Orders
                                                    </h3>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div class="kt-widget14__chart">
                                                        <canvas id="kt_chart_paypal-bitcoin" style="height: 140px; width: 140px;"></canvas>
                                                    </div>
                                                    <div class="kt-widget14__legends">
                                                        <div class="kt-widget14__legend">
                                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                                            <span class="kt-widget14__stats"><span id="paypalOrdersStats"></span> Paypal Order(s)</span>
                                                        </div>
                                                        <div class="kt-widget14__legend">
                                                            <span class="kt-widget14__bullet kt-bg-brand"></span>
                                                            <span class="kt-widget14__stats"><span id="bitcoinOrdersStats"></span> Bitcoin Order(s)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                    <div class="col-xl-4">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        Free Orders vs. Paid Orders
                                                    </h3>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div class="kt-widget14__chart">
                                                        <canvas id="kt_chart_free-paid" style="height: 140px; width: 140px;"></canvas>
                                                    </div>
                                                    <div class="kt-widget14__legends">
                                                        <div class="kt-widget14__legend">
                                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                                            <span class="kt-widget14__stats"><span id="freeOrdersStats"></span> Free Order(s)</span>
                                                        </div>
                                                        <div class="kt-widget14__legend">
                                                            <span class="kt-widget14__bullet kt-bg-brand"></span>
                                                            <span class="kt-widget14__stats"><span id="paidOrdersStats"></span> Paid Order(s)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                    <div class="col-xl-4">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        Active User vs. Free Users
                                                    </h3>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div class="kt-widget14__chart">
                                                        <canvas id="kt_chart_active-passive" style="height: 140px; width: 140px;"></canvas>
                                                    </div>
                                                    <div class="kt-widget14__legends">
                                                        <div class="kt-widget14__legend">
                                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                                            <span class="kt-widget14__stats"><span id="activeUsers"></span> Active User(s)</span>
                                                        </div>
                                                        <div class="kt-widget14__legend">
                                                            <span class="kt-widget14__bullet kt-bg-brand"></span>
                                                            <span class="kt-widget14__stats"><span id="freeUsers"></span> Free User(s)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                </div>
                            </div>

                            <!-- end:: Content -->
                        </div>
                    </div>