
function show(){
	var key=document.getElementById('key');

	var button=document.getElementById('toggle');
	if(key.type=='password'){
		key.type='text';
		button.value='hide';
	}else{
		key.type='password';
		button.value='show';
	}
}
