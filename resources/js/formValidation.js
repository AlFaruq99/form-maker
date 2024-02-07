class FormValidation {

    validateForm = (array) => {

        const filteredArray = array.filter((item) => {
            if (item.required == 1 && item.answer == null) {
                return item    
            }
        });
        return filteredArray;
        
    }

}

export default FormValidation;