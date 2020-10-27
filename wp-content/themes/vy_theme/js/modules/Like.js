import $ from 'jquery'
class Like{
    constructor(){
        this.events()
    }
    events(){
        $('.like-box').on('click', this.ourClickDispatcher.bind(this));
    }
    // methods
    ourClickDispatcher(e){
        var currentLikeBox = $(e.target).closest('.like-box')
        console.log(currentLikeBox.data('exists'))
        if(currentLikeBox.attr('data-exists') == 'yes'){
            this.deleteLike(currentLikeBox)
        } else{
            this.createLike(currentLikeBox)
        }
    }

    createLike(currentLikeBox){
        var professorId = currentLikeBox.data('professor')
        console.log('create')
        $.ajax({
            beforeSend: (xhr) =>{
                xhr.setRequestHeader('X-WP-Nonce', vyThemeData.nonce);
            },
            url: vyThemeData.root_url + '/wp-json/vyTheme/v1/like',
            type: 'POST',
            // Send professorID to like-route.php
            // Same as url: vyThemeData.root_url + '/wp-json/vyTheme/v1/like?professorID='+ professorId
            data: {'professorId': professorId},
            // response = ID of the like post
            success: (res)=>{
                currentLikeBox.attr('data-exists','yes')
                var likeCount = parseInt(currentLikeBox.find('.like-count').html(),10)
                likeCount++
                currentLikeBox.find('.like-count').html(likeCount)
                // res is the id of Like post from return wp_insert_post
                // If user haven't like, then click like, change data-like to the like id 
                // because from single-professor.php, only when like and refresh, data-like = likeID
                currentLikeBox.attr('data-like', res)
            }
        })
    }

    deleteLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) =>{
                xhr.setRequestHeader('X-WP-Nonce', vyThemeData.nonce);
            },
            url: vyThemeData.root_url + '/wp-json/vyTheme/v1/like',
            dataType:'text',
            type: 'DELETE',
            // Send professorID to like-route.php
            // Same as url: vyThemeData.root_url + '/wp-json/vyTheme/v1/like?professorID='+ professorId
            data: {'likeID': currentLikeBox.data('like')},
            // response = ID of the like post
            success: (res)=>{
                currentLikeBox.attr('data-exists','no')
                var likeCount = parseInt(currentLikeBox.find('.like-count').html(),10)
                likeCount--
                currentLikeBox.find('.like-count').html(likeCount)
                currentLikeBox.attr('data-like', '')
            },
            error: res => {
                console.log(res)
            }
        })
    }

}
export default Like

// site ground
// vy T....vy..*