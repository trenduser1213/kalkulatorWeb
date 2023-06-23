@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{url('/ajax/hitung')}}" method="POST" id="hitung">
                        @csrf
                        <div class="mb-3">
                            <label for="operand1" class="form-label">Operand ke 1</label>
                            <input type="number" class="form-control" id="operand1" name="operand1" required>
                        </div>
                        <div class="mb-3">
                            <label for="operator" class="form-label">Operator</label>
                            <select id="operator" class="form-select" name="operator">
                              <option value="+">+</option>
                              <option value="-">-</option>
                              <option value="*">*</option>
                              <option value="/">/</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="operand2" class="form-label">Operand ke 2</label>
                            <input type="number" class="form-control" id="operand2" name="operand2" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <Label>
                        Hasil : <p id="result"></p>
                    </Label>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#hitung').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this); // Membuat objek FormData dari formulir

        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#result').empty();
                var result = response.result;
                $('#result').text(result);
                var operand1 = formData.get('operand1');
                var operator = formData.get('operator');
                var operand2 = formData.get('operand2');
                var message = "Operand 1: " + operand1 +
                              "\nOperator: " + operator +
                              "\nOperand 2: " + operand2 +
                              "\nResult: " + result;
                alert(message);
            },
            error: function(xhr, status, error) {
                alert("An error occurred");
                console.log(xhr.responseText);
            }
        });
    });
    });
</script>
@endsection
