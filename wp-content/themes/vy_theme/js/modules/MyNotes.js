import $ from 'jquery';

class MyNotes {
    constructor(){
        this.events()
    }

    events(){
        $("#my-notes").on('click', '.delete-note',this.deleteNote)
        $("#my-notes").on('click', '.edit-note',this.editNote.bind(this))
        $("#my-notes").on('click', '.update-note',this.updateNotes.bind(this))
        $(".submit-note").on('click', this.createNote)
    }

    // Method
    createNote(){
        var newPost = {
            'title': $('.new-note-title').val(),
            'content': $('.new-note-body').val(),
            'status': 'publish'
        }
        $.ajax({
            beforeSend: (xhr) =>{
                xhr.setRequestHeader('X-WP-Nonce', vyThemeData.nonce);
            },
            url: vyThemeData.root_url + '/wp-json/wp/v2/note',
            type: 'POST',
            data: newPost,
            success: (res)=>{
                $('.new-note-title, .new-note-body').val('')
                $(`
                <li data-id="${res.id}" data-state=''>
                    <input readonly class="note-title-field" value="${res.title.raw}">
                    <span class="edit-note"><i class='fa fa-pencil'>Edit</i></span>
                    <span class="delete-note"><i class='fa fa-trash-o'>Delete</i></span>
                    <textarea readonly class="note-body-field">${res.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden='true'></i>Save</span>
                </li>
                `).prependTo('#my-notes').hide().slideDown()
            },
            error: res => {
                if(res.responseText == 'You have reached your limit. Delete some note to create a new one'){
                    $('.note-limit-message').addClass('active')
                }
                console.log(res)
            }
        })
    }
    deleteNote(e){
        //  vyThemeData.root_url In functions.php
        // Wordpress had a Nonce(number once, token) to check. No nonce = cannot execute delete
        // nonce can be typed in wp_localize_script
        var thisNote = $(e.target).parents('li')
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', vyThemeData.nonce)
            },
            url: vyThemeData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: (res) => {
                thisNote.slideUp()
                if(res.userNoteCount < 5){
                    $('.note-limit-message').removeClass('active')
                }
            },
            error: (res)=> {
                console.log(res)
            }
        })
    }

    updateNotes(e){

        var thisNote = $(e.target).parents('li')
        console.log(thisNote.attr('data-id'))
        this.makeNoteReadOnly(thisNote)
        var updatedPost  ={
            'title': thisNote.find('.note-title-field').val(),
            'content': thisNote.find('.note-body-field').val()
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', vyThemeData.nonce)
            },
            url: vyThemeData.root_url + '/wp-json/wp/v2/note/' + thisNote.attr("data-id"),
            type: 'POST',
            data: updatedPost,
            success: () => {
                this.makeNoteReadOnly(thisNote)
            },
            error: (res)=> {
                console.log(res)
            }
        })
    }

    editNote(e){
        var thisNote = $(e.target).parents('li')
        if (thisNote.data('state') == 'editable'){
            this.makeNoteReadOnly(thisNote)
        } else {
            this.makeNoteEditable(thisNote)
        }
    }

    makeNoteReadOnly(thisNote){
        thisNote.data('state','cancel')
        thisNote.find('.edit-note').html("<i class='fa fa-pencil'>Edit</i>")
        thisNote.find('.note-title-field, .note-body-field').attr('readonly','readonly').removeClass('note-active-field')
        thisNote.find('.update-note').removeClass('update-note--visible')
    }

    makeNoteEditable(thisNote){
        thisNote.data('state','editable')
        thisNote.find('.edit-note').html("<i class='fa fa-times'>Cancel</i>")
        thisNote.find('.update-note').addClass('update-note--visible')
        thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field')
    }

    updateNote(){

    }

}

export default MyNotes