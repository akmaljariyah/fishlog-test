var token = localStorage.getItem('token');
var baseUrl = window.location.origin;

axios.defaults.baseURL = '/api/';
axios.defaults.headers.common = {
    'Authorization': `Bearer ${token}`,
    'content-type': 'application/json',
    'accept': 'application/json'
};
if(token === null)
{
    baseUrl = window.location.origin;
    localStorage.setItem('redirect', window.location.href);
    window.location.href = baseUrl+'/login';
}

function logout()
{
    localStorage.removeItem('token');
    window.location.href = baseUrl+'/login';
}