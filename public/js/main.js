window.addEventListener('load', function(){
// Toggle likes and AJAX request
	var likes = document.querySelectorAll('.btn-like, .btn-dislike');
	var i;
	var url = 'http://localhost/www/php_projects/instagram_clone/public/';

	for (i = 0; i < likes.length; i++){
	    likes[i].addEventListener('click', function toggleLike(){
	    		if(this.classList.contains('btn-like')){
	    			this.classList.remove('btn-like');
	    			this.classList.add('btn-dislike');
	    			this.setAttribute('src', url + 'img/heart-black.png');

	    			$.ajax({
	    				url: url + /dislike/ + $(this).data('id'),
	    				type: 'GET',
	    				success: function(response){
	    					if(response.like){
	    						console.log('DISLIKE');
	    					} else {
	    						console.log('Error al dar DISLIKE');
	    					}
	    				}
	    			});
	    		} else if(this.classList.contains('btn-dislike')){
	    			this.classList.remove('btn-dislike');
	    			this.classList.add('btn-like');
	    			this.setAttribute('src', url + 'img/heart-red.png');

	    			$.ajax({
	    				url: url + /like/ + $(this).data('id'),
	    				type: 'GET',
	    				success: function(response){
	    					if(response.like){
	    						console.log('LIKE');
	    					} else {
	    						console.log('Error al dar LIKE');
	    					}
	    				}
	    			});
	    		}
	    });             
	}

	/*
	$('.btn-like').css('cursor', 'pointer');
	$('.btn-dislike').css('cursor', 'pointer');

	function like(){
		$('btn-like').click(function(){
			console.log('like');
			$(this).addClass('btn-dislike').removeClass('btn-like');
			$(this).attr('src', 'img/heart-red.png');
			dislike();
		})
	}
	like();

	function dislike(){
		$('btn-dislike').click(function(){
			console.log('like');
			$(this).addClass('btn-like').removeClass('btn-dislike');
			$(this).attr('src', 'img/heart-black.png');
			like();
		});
	}
	dislike();
	*/

/*
// Buscador
	var buscador = document.querySelector('#buscador');
	var searchInput = document.querySelector('#search');

	buscador.addEventListener('submit', function searchParam(){
		this.setAttribute('action', url + 'usuarios/' + searchInput.value);
	})
*/
})