const handleThemeUpdate = (cssVars) => {
    const root = document.querySelector(':root');
    const keys = Object.keys(cssVars);
    keys.forEach(key => {
        root.style.setProperty(key, cssVars[key]);
    });
}
function dynamicPrimaryColor(primaryColor) {
    primaryColor.forEach((item) => {
        item.addEventListener('input', (e) => {
            document.body.style.setProperty('--primary-rgb', hex2rgb(e.target.value)) ;
        });
    });
}
const hex2rgb = (hex) => {
    const r = parseInt(hex.slice(1, 3), 16)
    const g = parseInt(hex.slice(3, 5), 16)
    const b = parseInt(hex.slice(5, 7), 16)
    // return {r, g, b} // return an object
    return [ r, g, b ]
}

function dynamicPrimaryBackground(bgColor) {
    bgColor.forEach((item) => {
        item.addEventListener('input', (e) => {
            document.body.style.setProperty('--body-color',  e.target.value+ 'dd');
            document.body.style.setProperty('--custom-white' , e.target.value);
        });
    });
}

$(document).ready(function () {
    // Light theme color picker
    // const LightThemeSwitchers = document.querySelectorAll('.light-theme .switch_section span');
    const dynamicPrimaryLight = document.querySelectorAll('input.color-primary-light');
    const dynamicBackground = document.querySelectorAll('input.background-primary-light');

    // themeSwitch(LightThemeSwitchers);
    dynamicPrimaryColor(dynamicPrimaryLight);
    dynamicPrimaryBackground(dynamicBackground);

    localStorageBackup();
});

function localStorageBackup() {
    // if there is a value stored, update color picker and background color
    // Used to retrive the data from local storage
    if (localStorage.gowellprimaryColorrgb) {
        document.querySelector('body').style.setProperty('--primary-rgb', localStorage.gowellprimaryColorrgb);
    }
    if (localStorage.gowellbgColor) {
        document.querySelector('body').classList.add('dark-theme');
        document.querySelector('body').classList.remove('light-theme');
        $('#myonoffswitch4').prop('checked', true);
        $('#myonoffswitch3').prop('checked', false);
        document.querySelector('body').style.setProperty('--body-color', localStorage.gowellbgColor);
        document.querySelector('body').style.setProperty('--custom-white', localStorage.gowellthemeColor);
    }

    if (localStorage.gowellrtl) {
        $('body').addClass('rtl');
        $('#myonoffswitch2').prop('checked', true);
        $('#myonoffswitch1').prop('checked', false);
    }

    if (localStorage.gowelldark) {
        $('body').addClass('dark-theme');
        $('#myonoffswitch4').prop('checked', true);
        $('#myonoffswitch3').prop('checked', false);
    }

    if(localStorage.gowelllight){
        $('body').addClass('light-theme');
        $('#myonoffswitch3').prop('checked', true);
        $('#myonoffswitch4').prop('checked', false);
        document.querySelector('body').style.removeProperty('--body-color', localStorage.gowellbgColor);
        document.querySelector('body').style.removeProperty('--custom-white', localStorage.gowellthemeColor);
    }

}

// triggers on changing the color picker
function changePrimaryColor() {

    var userColor = document.getElementById('colorID').value;
    localStorage.setItem('gowellprimaryColorrgb', hex2rgb(userColor));
    
    names()
}
// triggers on changing the color picker
function changeBackgroundColor() {

    var userColor = document.getElementById('bgID').value;
    localStorage.setItem('gowellbgColor', userColor + 'dd');
    localStorage.setItem('gowellthemeColor', userColor);
    

    document.querySelector('body').classList.add('dark-theme');
    document.querySelector('body').classList.remove('light-theme');
    $('#myonoffswitch4').prop('checked', true);
    names()
    
    localStorage.setItem('gowelldark', true);
    localStorage.removeItem('gowelllight');
}


function names() {

    let primaryColorVal = getComputedStyle(document.documentElement).getPropertyValue('--primary-rgb').trim();
    //get variable
    let myVarVal = localStorage.getItem("gowellprimaryColorrgb") ||primaryColorVal;

    // For index2.html
	if(document.querySelector('#survey') !== null){
        survey(myVarVal);
    }
	if(document.querySelector('#lineChart1') !== null){
        lineChart1(myVarVal);
    }
    // For index3.html
	if(document.querySelector('#purchase') !== null){
        purchase(myVarVal);
    }
	if(document.querySelector('#feedback') !== null){
        feedback(myVarVal);
    }
    // For index3.html
	if(document.querySelector('#echart1') !== null){
        echart1(myVarVal);
    }
	if(document.querySelector('#lineChart') !== null){
        lineChart(myVarVal);
    }
}
names()
