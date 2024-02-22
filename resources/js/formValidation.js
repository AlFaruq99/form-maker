class FormValidation {

    validateForm = (array) => {
        console.log(array[0]);return;
        if (array.length > 0) {
            const filteredArray = array.filter((item) => {
                if (item.required == 1 && item.answer == null) {
                    return item    
                }
            });
            return filteredArray;
            
        }

        return [];

        
    }

}

export default FormValidation;