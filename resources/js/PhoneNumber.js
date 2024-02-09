class PhoneNumber {
    formatPhoneNumber(phoneNumber) {
    
        phoneNumber = phoneNumber.replace(/\D/g, '');
        
        if (phoneNumber.startsWith('62')) {
          phoneNumber = phoneNumber.slice(2);
        }
        return '62' + phoneNumber;
        
      }
      
}

export default PhoneNumber;