const copyToClipboard = str => {
    event.preventDefault();
    const el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    let flag = event.currentTarget.querySelector('#share--mod');
    flag.innerHTML = 'Copied';
    setTimeout(()=> {
        flag.innerHTML = 'Share';
    }, 4000);
  };
