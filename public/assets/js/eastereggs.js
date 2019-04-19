let result = '';
document.addEventListener('keydown', function (event) {
    console.log(event.key);
    result += event.key;
    if (result.includes('cat')) {
        document.location.href = 'https://www.youtube.com/watch?v=_V6flr-zopM';
    }
});