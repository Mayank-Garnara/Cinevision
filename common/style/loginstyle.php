* {
padding: 0;
margin: 0;
box-sizing: border-box;
}
::selection{
    color: white;
    background-color: rgb(183, 83, 83);
}
body {
display: flex;
height: 100vh;
background-color: #343a40;
background-image : url('../../common/images/background.png');
background-repeat:no-repeat;
background-size: cover;
background-position: center;
}

.cinevision_container{
    background-image: linear-gradient(100deg, rgba(0, 0, 0, 0.829),rgba(255, 255, 255, 0.014));;
    display:flex;
    justify-content:center;
    width: 100vw;
}

#container {
margin: auto;
display: flex;
color: #f8f9fa;
flex-direction: column;
width: 500px;
box-shadow: 1px 2px 71px -6px rgba(0, 0, 0, 0.67);
height: fit-content;
font-family: 'Ubuntu', sans-serif;
background-color: rgba(0, 0, 0, 0.747);
padding: 50px 20px;
border-radius: 10px;
}

#Heading {
padding: 10px;
text-align: center;
font-size: 2.5em;
font-weight: 900;
}

label {
font-size: 1.2em;
font-weight: 500;
margin: 10px 0px;
}

input {
padding: 10px;
border-top-right-radius: 10px;
height: 50px;
border: none;
background-color: #6c757d;
border-bottom-right-radius: 10px;
font-size: 19.2px;

color: #f8f9fa;
}

input:focus {
outline: none;
background-color: none;
border-bottom: 1.5px solid red;
}

input::placeholder {
color: #f8f9fa;
font-size: 19.2px;
}

.row {
width: 100%;
height: fit-content;
display: grid;
grid-template-columns: 10% 90%;
grid-template-rows: 50px;
}

.icon {
height: 50px;
margin-right: 1px;
background-color: #6c757d;
border-top-left-radius: 10px;
padding: 10px;
border-bottom-left-radius: 10px;
fill: white;
}

button {
width: fit-content;
margin: 20px auto;
padding: 10px 20px;
outline: none;
border: none;
border-radius: 20px;
font-weight: 700;
color: white;
background-color: rgb(169, 35, 35);
font-family: 'Ubuntu', sans-serif;
font-size: 1.1em;
cursor: pointer;
transition-duration: 0.25s;
}

button:hover {
background-color: red;
}

span {
display: flex;
justify-content: space-between;

}

a {
text-decoration: none;
color: #99e2b4;
}

span>span>a {
margin: 0px 5px
}

a:hover {
color: #06d6a0;
}




<!--  -->
.error-border {
border: 2px solid red !important;
}
.shake-animation {
animation: shake 0.3s ease-in-out;
}
@keyframes shake {
0% { transform: translateX(0); }
25% { transform: translateX(-5px); }
50% { transform: translateX(5px); }
75% { transform: translateX(-5px); }
100% { transform: translateX(0); }
}
.error-message {
color: red;
display: none;
}





/* Spinner Container */
.spinner-container {
display: flex;
justify-content: center;
align-items: center;
height: 30px; /* Full screen height */
background-color:rgba(249, 249, 249, 0); /* Optional background */
}

/* Spinner */
.spinner {
width: 50px;
height: 50px;
border: 5px solid rgba(0, 0, 0, 0.1); /* Light gray border */
border-top: 5px solid white; /* Blue border for animation */
border-radius: 50%;
animation: spin 1s linear infinite; /* Infinite spinning */
}

/* Keyframes for spinning animation */
@keyframes spin {
0% {
transform: rotate(0deg);
}
100% {
transform: rotate(360deg);
}
}