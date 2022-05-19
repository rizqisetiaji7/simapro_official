function chooseFile(btnClick, inputEl) {
    $(document).on('click', btnClick, (e) => {
        e.preventDefault()
        $(inputEl).click()
    })
}