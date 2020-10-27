import $ from 'jquery';
class Search {
    // describe and create
    constructor(){
        this.previousValue
        this.searchField =null
        this.resultsDiv = $('#search-overlay__results')
        this.openButton = $(".js-search-trigger")
        this.closeButton = $(".search-overlay__close")
        this.searchOverlay = $('.search-overlay')
        this.events()
        this.isOverlayOpen = false
        this.isSpinnerVisible = false
        this.typingTimer
    }
    // events
    events(){
        this.openButton.on('click',this.openOverlay.bind(this));
        this.closeButton.on('click',this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));

    }
    // methods
    typingLogic(){
        if(this.searchField.val() != this.previousValue){
            clearTimeout(this.typingTimer)
            if (this.searchField.val()){
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>')
                    this.isSpinnerVisible = true
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 1000)
            }else{
                this.resultsDiv.html('')
                this.isSpinnerVisible = false
            }
        }
        this.previousValue = this.searchField.val()
    }
    getResults(resultsDiv = this.resultsDiv){
        $.getJSON(vyThemeData['root_url']+'/wp-json/vyTheme/v1/search?term='+this.searchField.val(), results=>{
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.generalInfo.length >0 ? '<ul class="link-list min-list">' : '<p>No general information found</p>' }
                        ${results.generalInfo.map(item => `<li><a href="${item.link}">${item.title}</a> ${item.type? "by " + item.authorName: ""}</li>`).join('')}
                        ${results.generalInfo.length >0 ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length >0 ? '<ul class="link-list min-list">' : `<p>No programs found <a href="${vyThemeData['root_url']}/programs">View all program</a></p>` }
                        ${results.programs.map(item => `<li><a href="${item.link}">${item.title}</a> ${item.type? "by " + item.authorName: ""}</li>`).join('')}
                        ${results.programs.length >0 ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length >0 ? '<ul class="link-list min-list">' : '<p>No general information found</p>' }
                        ${results.professors.map(item => `<li><a href="${item.link}">${item.title}</a> ${item.type? "by " + item.authorName: ""}</li>`).join('')}
                        ${results.professors.length >0 ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length >0 ? '<ul class="link-list min-list">' : '<p>No general information found</p>' }
                        ${results.events.map(item => `<li><a href="${item.link}">${item.title}</a> ${item.type? "by " + item.authorName: ""}</li>`).join('')}
                        ${results.events.length >0 ? '</ul>' : ''}
                    </div>
                </div>
            `);
        })
    }

    keyPressDispatcher(e){
        if(e.keyCode == 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')){
            this.openOverlay()
        }
        if(e.keyCode == 27 && this.isOverlayOpen){
            this.closeOverlay()
        }
    }
    openOverlay(){
        this.searchField = $("#search-term")
        this.searchField.on("keyup",this.typingLogic.bind(this))
        setTimeout(()=>this.searchField.focus(),301)
        this.searchOverlay.addClass('search-overlay--active')
        $("body").addClass('body-no-scroll')
        this.isOverlayOpen = true
    }

    closeOverlay(){
        this.searchOverlay.removeClass('search-overlay--active')
        $("body").removeClass('body-no-scroll')
    }
}
export default Search