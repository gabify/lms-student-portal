const srcode = document.querySelector('#srcode')
const btnSubmit = document.querySelector('#btnSubmit')
srcode.addEventListener('input', e=>{
    const val = e.target.value.trim()

    if(isEmpty(val)){
        setError(srcode, 'Please provide an srcode')
        btnSubmit.disabled = true
    }else{
        if(isValid(val)){
            setSuccess(srcode)
            btnSubmit.disabled = false
        }else{
            setError(srcode, 'The provided srcode is invalid.')
            btnSubmit.disabled = true
        }
    }
})



const isEmpty = (srcodeVal) =>{
    if(srcodeVal === ''){
        return true
    }
    return false
}

const isValid = (srcodeVal) =>{
    const regex = /^[\d]{2}-[\d]{5}$/
    return regex.test(srcodeVal);
}

const setError = (element, message) =>{
    const errorMessage = element.nextElementSibling;
    const label = element.previousElementSibling;
    errorMessage.innerText = message;

    element.classList.add('error')
    element.classList.remove('success')
    label.classList.add('text-danger')
}

const setSuccess = (element) => {
    const errorMessage = element.nextElementSibling;
    const label = element.previousElementSibling;
    errorMessage.innerText = "";

    element.classList.add('success')
    element.classList.remove('error')
    label.classList.remove('text-danger')
}