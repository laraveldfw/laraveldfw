<script type="text/javascript">
    console.log('swal fire');
    Swal.fire({
        text: "{{ $message }}",
        icon: {!! $type ? '"' . $type . '"' : 'undefined' !!},
        title: "{{ $title }}"
    });
</script>
