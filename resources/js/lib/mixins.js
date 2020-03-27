const titleMixin = {
    watch: {
        title(value){
            document.title = value
        }
    },
    computed: {
        title(){
            return 'Set title by setting the computed property title.'
        }
    }
};

module.exports = {
    titleMixin
};
