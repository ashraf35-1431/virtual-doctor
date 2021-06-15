@extends('doctor.layouts.app')

@section('breadcrumbs', Breadcrumbs::render('doctor.patient'))

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('doctor.users.patient.create') }}"
                            class="btn waves-effect waves-light btn-info">Add
                            Data</a>
                        <br>
                        <hr><br>
                        <div class="table-responsive">
                            <table id="zero_config" class="table v-middle">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="border-top-0">User</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0">Email</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Banned</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10">
                                                        @empty($user->image)
                                                            <a href="{{ route('doctor.users.patient.show', $user->id) }}"
                                                                class="btn btn-circle d-flex btn-{{ randomColor() }}">
                                                                {{ substr($user->name, 0, 2) }}
                                                            </a>
                                                        @else
                                                            <a class=""
                                                                href="{{ route('doctor.users.patient.show', $user->id) }}">
                                                                <img src="{{ asset($user->image ?: 'assets/images/users/male_avatar.svg') }}"
                                                                    alt="users" class="rounded-circle" width="40" />
                                                            </a>
                                                        @endempty
                                                    </div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">{{ $user->user_name }}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <label
                                                    class="label label-{{ isActiveClass($user->isActive) }}">{{ isActiveText($user->isActive) }}</label>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input name="ban" {{ isBan($user, 'check') }} data-onstyle="info"
                                                        data-offstyle="light" data-on="True" class="toggle patient-ban"
                                                        type="checkbox" data-toggle="toggle" data-off="False"
                                                        data-width="100" itemid="{{ $user->id }}">
                                                </div>
                                            </td>
                                            <td class="d-flex justify-content-around">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-danger" type="button"
                                                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        {{-- Dropdown button --}}
                                                        <i class="mdi mdi-heart-pulse"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('doctor.healths.single', $user->id) }}">Health</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('doctor.reports.single', $user->id) }}">Report</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="{{ route('doctor.users.patient.appointment-index', $user->id) }}"
                                                    class="btn btn-secondary" title="appointment">
                                                    <i class="mdi mdi-calendar-check"></i>
                                                </a>
                                                <a href="{{ route('doctor.users.patient.show', $user->id) }}"
                                                    class="btn btn-success text-white" title="show">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(() => {
            $('.patient-ban').on('change', (e) => {
                $.ajax({
                    type: "POST",
                    url: "{{ route('doctor.users.patient.ban') }}",
                    data: {
                        id: e.target.getAttribute('itemid'),
                        ban: $(event.target).hasClass('toggle-on')
                    },
                    success: function(data) {
                        if (data == "true") {
                            toastr.info("User not Banned");
                        } else if (data == "false") {
                            toastr.info("User successfullly Banned");
                        }
                    },
                    error: function(error) {
                        toastr.error("Something Went Wrong!");
                    }
                });
            });
        });

    </script>
@endpush
