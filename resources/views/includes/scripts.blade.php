  <!-- Jquery-->
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap.bundle.js') }}" type="text/javascript"></script>
  {{--<script src="{{ asset('js/jquery-ui.js') }}"></script>--}}
  {{--<script src="{{ asset('js/counter.js') }}"></script>--}}
  <script src="{{ asset('js/calender.js') }}"></script>
  <script src="{{ asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/carousel.js') }}" type="text/javascript"></script>  
  <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/sweetalert.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/filter-multi-select-bundle.min.js') }}"></script>

  {{-- jquery-validator --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <!-- Jquery-->
  
<script>
  $(document).ready(function(){

       $('.school_type').click(function(e){

            e.preventDefault();
            let value = $(this).data('school_type');
            $('#schoolType').val(value);
            $('#schoolTypeForm').submit();
       })
  })
</script>
<script>
    $('.add-fav').click(function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        activ = addToFav(id);
        console.log(activ,'return');
        if(activ == 'true'){
            $(this).addClass("active");
            $('.fav-tooltip').text('Added to Favourite');
        }else{
            $(this).removeClass("active");
            $('.fav-tooltip').text('Add to Favourite');
        }
    });

    function addToFav(val) {
       let school_id = val;
        let activ = null;
        $.ajax({
            type: "POST",
            async: false,
            url: "{{route('user.add.favourite')}}",
            data: {
              school_id: school_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $(this).removeClass("active");
                console.log(data.result.status.meaning, $(this).closest("a"),data.result.status.code == '-36712');
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: data.result.status.meaning,
                    showConfirmButton: false,
                    timer: 2500
                });
                if(data.result.status.code == '-36712'){
                    activ = 'true';
                }else{
                    activ = 'false';
                }
                console.log(activ,'1');
            }
        });
        console.log(activ,'2');
        return activ;
    }
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const curriculumCheckboxes = document.querySelectorAll('.curriculum-checkbox');
    const schoolLevelSelect = document.getElementById('school_level');

    // Only run this logic if the elements exist on the page
    if (curriculumCheckboxes.length === 0 || !schoolLevelSelect) {
        return; // Exit safely
    }

    function updateSchoolLevels() {
        const selectedCurricula = Array.from(curriculumCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        Array.from(schoolLevelSelect.options).forEach(opt => {
            opt.disabled = false;
            opt.hidden = false;
        });

        if (selectedCurricula.includes("Montessori")) {
            Array.from(schoolLevelSelect.options).forEach(opt => {
                if (opt.dataset.levelName !== "Nursery") {
                opt.disabled = true;
                opt.hidden = true;
                opt.selected = false;
                }
            });
        }
    }

    curriculumCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSchoolLevels);
    });

    updateSchoolLevels();
    });
</script>