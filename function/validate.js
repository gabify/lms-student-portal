const form = document.querySelector('#signupform')
const srcode = document.querySelector('#srcode')
const firstname = document.querySelector('#firstname')
const lastname = document.querySelector('#lastname')
const program = document.querySelector('#program')
const course = document.querySelector('#course')
const btnSubmit = document.querySelector('#btnSubmit')

srcode.addEventListener('input', e =>{
    const val = e.target.value.trim()
    if(isEmpty(val)){
        setError(srcode, 'Please provide an srcode.')
        btnSubmit.disabled = true
    }else{
        if(isValid(val)){
            isRegistered(val)
            .then(result =>{
                if(result === 'registered'){
                    setError(srcode, 'The provided srcode is already registered')
                    btnSubmit.disabled = true
                }else{
                    setSuccess(srcode)
                    btnSubmit.disabled = false
                }
            }).catch(err=>{
                console.log(err)
            })
        }else{
            setError(srcode, 'The provided srcode is invalid')
            btnSubmit.disabled = true
        }
    }
})

form.addEventListener('submit', e=>{
    if(validateInputs().length != 4){
        e.preventDefault()
        e.stopPropagation()
    }   
})

const validateInputs = () => {
    const firstnameValue = firstname.value.trim()
    const lastnameValue = lastname.value.trim()
    const programValue = program.value.trim()
    const courseVal = course.value.trim()
    let inputs = [];

    if(isEmpty(firstnameValue)){
        setError(firstname, 'Please provided a first name.')
    }else{
        setSuccess(firstname)
        inputs.push(firstnameValue)
    }

    if(isEmpty(lastnameValue)){
        setError(lastname, 'Please provided a last name.')
    }else{
        setSuccess(lastname)
        inputs.push(lastnameValue)
    }
    
    if(isEmpty(programValue)){
        setError(program, 'Please provided a program.')
    }else{
        setSuccess(program)
        inputs.push(programValue)
    }
    if(isEmpty(courseVal)){
        setError(course, 'Please provide a course.')
    }else{
        setSuccess(course);
    }
    return inputs
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

const isEmpty = (value) =>{
    if(value === ''){
        return true;
    }
    return false;
}

const isValid = (srcode) =>{
    const regex = /^[\d]{2}-[\d]{5}$/
    return regex.test(srcode);
}

const isRegistered = async(srcode) =>{
    const response = await fetch('../lms-student-portal/function/validateSrcode.php?srcode='+srcode);
    const result = await response.text()
    return result;
}