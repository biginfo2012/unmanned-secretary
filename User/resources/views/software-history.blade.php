<x-app-layout>
    <!--begin::Content-->
    <div class="content-body">
        <!-- Ajax Sourced Server-side -->
        <section id="datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between align-items-center header-actions row mt-75 mx-0">
                                <div class="col-sm-12 col-lg-8 ps-xl-75 ps-0 pe-0">
                                    <form class="dt_adv_search" method="POST" id="search_form">
                                        @csrf
                                    </form>
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-start flex-lg-nowrap flex-wrap">
                                        <button type="button" class="dt-button add-new btn background-sky color-white" id="cost_export_excel"
                                                onclick="event.preventDefault();deleteSoftwareHistory('{{route('client.software-history-delete')}}')">
                                            {{__('delete')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0" id="table-part">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end::Content-->
    <script>
        addEventListener('pageshow', (event) => {
            getTableData('{{route('client.software-history-table')}}');
        });
    </script>
</x-app-layout>
