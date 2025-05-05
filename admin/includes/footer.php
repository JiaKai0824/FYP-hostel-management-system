<!DOCTYPE html>
<html>
<head>
    <style>
        html, body {
            
            margin: 0;
            padding: 0;
        }

        #sub-footer {
            position: fixed;
            right: 0;
            bottom: 0;
            width: 100%;
            background: #222;
            transition: transform 0.5s;
            transform: translateY(100%);
			z-index: 3;
        }

        #sub-footer.visible {
            transform: translateY(0);
        }
		

footer{background: #0e0e0e;}
footer ul.link-list li a{
	color: #8C8C8C;
}
footer ul.link-list li a:hover {
	color: #e91e63;
}

footer .widgetheading {
	position: relative;
}

footer .widget .social-network {
	position:relative;
}

footer .widget .flickr_badge {
    width: 100%;
}
footer .widget .flickr_badge img {
    margin: 0 9px 20px 0;
}

footer{
	color:#f8f8f8;
}

footer a {
	color:#fff;
}

footer a:hover {
	color: #e91e63;
}

footer h1, footer h2, footer h3, footer h4, footer h5, footer h6{
	color: #d3d3d3;
}

footer h5 a:hover, footer a:hover {
	text-decoration:none;
}

#sub-footer p{
	margin:0;
	padding:0;
}

#sub-footer span{
	color: #9e9e9e;
}

.copyright {
	text-align:left;
	font-size:12px;
}

#sub-footer ul.social-network {
	float:right;
}

footer .widget form  input#appendedInputButton {
		  display: block;
		  width: 91%;
		  -webkit-border-radius: 4px 4px 4px 4px;
			 -moz-border-radius: 4px 4px 4px 4px;
				  border-radius: 4px 4px 4px 4px;
	}
	
	footer .widget form  .input-append .btn {
		  display: block;
		  width: 100%;
		  padding-right: 0;
		  padding-left: 0;
		  -webkit-box-sizing: border-box;
			 -moz-box-sizing: border-box;
				  box-sizing: border-box;
				  margin-top:10px;
	}

     footer .col-lg-6{
		margin-bottom:20px;
        margin-top: 15px;
        height:70px;
	}

	#sub-footer ul.social-network {
		float:left;
	}

    .social-network li a {
        margin-left: 900px;

    }
    </style>
</head>
<body>
    <footer>
        <div id="sub-footer">
          
             
                    <div class="col-lg-6">
                        <div class="copyright">
                            <p>
                                <span>&nbsp;&copy;FYP hostel management system<br>
                                    <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Have problem? Contact us</a><br>
                                    <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(LIM: 011-37330158)</br></a>
                                    <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Ngo: 011-1773 5001)</br></a>
                                    <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Lo: 017-731 6730)</a>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="social-network">
                            <li><a class="waves-effect waves-dark" href="https://www.facebook.com/profile.php?id=100093057637474" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="waves-effect waves-dark" href="https://twitter.com/MMU_Hostel" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
    const subFooter = document.getElementById('sub-footer');
    let isPopupVisible = false;

    document.addEventListener('mousemove', function(event) {
        const mouseY = event.clientY;
        const footerHeight = subFooter.offsetHeight;

        if (mouseY >= window.innerHeight - footerHeight && !isPopupVisible) {
            subFooter.classList.add('visible');
        } else {
            subFooter.classList.remove('visible');
        }
    });

    subFooter.addEventListener('click', function(event) {
        event.stopPropagation();
        isPopupVisible = true;
        // Add code here to display the popup
    });

    document.addEventListener('click', function(event) {
        isPopupVisible = false;
        // Add code here to hide the popup
    });
</script>

</body>
</html>
