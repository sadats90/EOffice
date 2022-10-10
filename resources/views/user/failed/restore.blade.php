<form action="{{ route('failed/RestoreApplication', ['id' => encrypt($id)]) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="note" class="col-form-label">অনুচ্ছেদ</label>
        <textarea class="form-control" name="note" id="note"></textarea>
    </div>
    <div class="form-group">
        <label for="ExpiredDate" class="col-form-label">পরবর্তি মেয়াদ শেষ হওয়া তারিখ <span class="text-danger">*</span></label>
        <input class="form-control mb-2 datePicker" type="text" name="ExpiredDate" id="ExpiredDate" required autocomplete="off" placeholder="dd/mm/yy">
        <button type="submit" class="btn btn-sm btn-primary float-right">জমা দিন</button>
    </div>
</form>

<script>
    $("#ExpiredDate").datepicker({
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        showAnim: "slideDown",
        dateFormat: "dd/mm/yy"
    });
</script>
