document.addEventListener('DOMContentLoaded', function(){
    var detailButtons = document.querySelectorAll('.detailDataButton');

    detailButtons.forEach(function(button){
        button.addEventListener('click', function(){
            var id = this.getAttribute('data-id');
            window.location.href = `/detail/${id}`;
        })

    })
})