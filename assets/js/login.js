import ReactDOM from 'react-dom';
import React, { useState } from 'react';
import axios from 'axios';

require('../css/login.scss');

function LoginApp(props) {
    // Déclare une nouvelle variable d'état, qu’on va appeler « count »
    const [login, setLogin] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState(null);
    const [token, setToken] = useState(null);
    const [tokenExpireAt, setTokenExpireAt] = useState(null);
    const [username, setUsername] = useState(props.username);
    const [errorMessage, setErrorMessage] = useState(null);

    const doLogin = async function(){
        clearMessages();
        setMessage("Identification in progress");
        try {
            var response = await axios.post('/login',{
                username:login,
                password:password,
            })
            clearMessages();

            if(response.data.token)
            {
                setUsername(response.data.email);
                setToken(response.data.token);
                setTokenExpireAt(response.data.expireAt);
            }
            else
            {
                setUsername(null);
                setErrorMessage('Unknown response !');
            }
        } catch(e) {
            clearMessages();
            setUsername(null);
            if(e.response.data.error)
                setErrorMessage(e.response.data.error);
            else
                setErrorMessage('Unknown error !');
        }
    }

    const doLogout = async function(){
        clearMessages();
        setMessage("Logout in progress");
        setUsername(null);
        var response = await axios.get('/logout')
        setMessage("Logout done");

        setTimeout(() => {
            setMessage(null);
        },2000)
    }

    const clearMessages = function()
    {
        setToken(null);
        setTokenExpireAt(null);
        setMessage(null);
        setErrorMessage(null);
    }

    const handleReturnKey = function(e)
    {
        if(e.keyCode===13)
            doLogin();
    }

    return (
        <div className="loginApp">
            {username ?<div className="loginApp--panel" panel-type="username">
                <p>
                    <span>Logged as <em>{username}</em></span>
                    <button type="button" onClick={e => doLogout()}>Logout</button>
                </p>
                <p><a href="./api">Access API</a></p>
            </div>:null}

            {token ? <div className="loginApp--panel" panel-type="token">
                <p>You can now use the following token as "Bearer Token"</p>
                <blockquote>{token}</blockquote>
                <p>This token is valid until <em>{tokenExpireAt}</em></p>
            </div>:null}

            {message ? <div className="loginApp--panel" panel-type="message">
                <p>{message}</p>
            </div>:null}

            {errorMessage ? <div className="loginApp--panel" panel-type="error">
                <p>{errorMessage}</p>
            </div>:null}

            {username ? null :
                <div className="loginApp--panel" panel-type="form">
                    <div className="loginApp--formField"><input type="text" name="login" value={login} placeholder="Login" onKeyUp={e => handleReturnKey(e) } onChange={e => setLogin(e.target.value)}/></div>
                    <div className="loginApp--formField"><input type="password" name="password" value={password} placeholder="Password" onKeyUp={e => handleReturnKey(e) } onChange={e => setPassword(e.target.value)}/></div>
                    <div className="loginApp--formField"><button type="button" onClick={e => doLogin()}>Ok</button></div>
                </div>
            }
        </div>
    );
}

var container = document.getElementById('login-root');
ReactDOM.render(<LoginApp username={container.getAttribute('data-username')}/>,container);