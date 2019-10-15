@include('header')

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Add Student</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" action="{{url('addStudent')}}" method="post">
                      {{ csrf_field() }}
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Name</label>
                                    <input class="input--style-4" type="text" name="name" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Class</label>
                                    <input class="input--style-4" type="text" name="class" required>
                                </div>
                            </div>                       
                            <div class="input-group">
                                <label class="label">Gender</label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="gender" required>
                                        <option disabled="disabled" selected="selected">Choose option</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                            <div class="input-group">
                                <label class="label">Assigned to</label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="teacher" required>
                                        <option disabled="disabled" selected="selected">Select Teacher</option>
                                        @if(count($teachers)>0)
                                        @foreach($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                            <div class="p-t-15">
                                <button class="btn btn--radius-2 btn--blue" type="submit">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<!-- end document-->