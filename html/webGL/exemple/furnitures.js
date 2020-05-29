			import * as THREE from '../build/three.module.js';
			import { GLTFLoader } from './jsm/loaders/GLTFLoader.js';

			const loader = new GLTFLoader();
			var pi = Math.PI;


//load gltf object
function office(){
    //Vriable of office and all everythink on it
			var office, woodOffice, computerScreen, keyboard, mouse, mousePad;

				office = new THREE.Group();


				//load woodOffice
				loader.load('models/furnitures/woodOffice/scene.gltf', function ( gltf ) {
					woodOffice = gltf.scene;
					woodOffice.scale.set(1,1,1);
					office.add( woodOffice );
    		});

				//load computerScreen
				loader.load('models/computerScreen/scene.gltf', function ( gltf ) {
					computerScreen = gltf.scene;
					computerScreen.scale.set(8,8,8);
					computerScreen.rotation.y = pi/2;
					computerScreen.position.set(-12, 42,17);
					office.add( computerScreen );
    		});

				//load keyboard
				loader.load('models/keyboard/scene.gltf', function ( gltf ) {
					keyboard = gltf.scene;
					keyboard.scale.set(1,1,1);
					keyboard.rotation.y = pi/2;
					keyboard.position.set(5, 42,15);
					office.add( keyboard );
    		});

				//load mouse
				loader.load('models/mouse/scene.gltf', function ( gltf ) {
					mouse = gltf.scene;
					mouse.scale.set(0.8,0.8,0.8);
					mouse.rotation.y = pi/2;
					mouse.position.set(-5, 43, -20);
					office.add( mouse );
    		});

				//load mousepad
				loader.load('models/mousePad/scene.gltf', function ( gltf ) {
					mousePad = gltf.scene;
					mousePad.scale.set(0.2,0.2,0.2);
					mousePad.rotation.y = pi/2;
					mousePad.position.set(0, 43, -20);
					office.add( mousePad );
    		});

				office.scale.set(8,8,8);
				office.position.set(500,0,-200);
				office.rotation.set(0,-pi/2,0)

				office.castShadow = true;
				office.receiveShadow = true;
				return office;

}

function bed(){
	        // bed

		//base
		var bedGroup;
		bedGroup = new THREE.Group();
		var geometry4 = new THREE.BoxBufferGeometry( 50, 500, 50 );
        var texture2 = new THREE.TextureLoader().load('textures/wood.png');
        var material3 = new THREE.MeshPhongMaterial( {map: texture2} );

        var base1 = new THREE.Mesh( geometry4, material3 );
        base1.position.set(- 1000 + (50 / 2), 250, - 400 + (50 / 2));

        var base2 = base1.clone();
        base2.position.x += 475;

        var geometry5 = new THREE.BoxBufferGeometry( 50, 250, 50 );
        var base3 = new THREE.Mesh( geometry5, material3 );
        base3.position.set(- 1000 + (50 / 2), 125, 500 - (50 / 2));

        var base4 = base3.clone();
        base4.position.x += 475;

        var geometry6 = new THREE.BoxBufferGeometry( 50, 800, 50 );
        var base5 = new THREE.Mesh( geometry6, material3 );
        base5.rotation.x = Math.PI / 2;
        base5.position.set(- 1000 + (50 / 2), 200, 50);

        var base6 = base5.clone();
        base6.position.x += 475;

        var geometry7 = new THREE.BoxBufferGeometry( 50, 425, 50 );
        var base7 = new THREE.Mesh( geometry7, material3 );
        base7.rotation.z = Math.PI / 2;
        base7.position.set( - 750 + (25 / 2), 200, 500 - (50 / 2));

        for (let i = 100; i < 875; i = i + 100) {
            var base8 = base7.clone();
            base8.position.z -= i;
            bedGroup.add(base8);
		}

        var geometry8 = new THREE.BoxBufferGeometry( 500, 250, 25 / 2 );
        var base9 = new THREE.Mesh( geometry8, material3 );
        base9.position.set( - 775, 350, - 400 + (50 / 2));


        // matress

        var geometry9 = new THREE.BoxBufferGeometry( 425, 100, 850 );
        //var texture3 = new THREE.TextureLoader().load('textures/mattress.jpg');
        //var material4 = new THREE.MeshBasicMaterial( {map: texture3} );
		var material4 = new THREE.MeshPhongMaterial( {color: 0xd3d3d3});
        var mattress = new THREE.Mesh( geometry9, material4 );
        mattress.position.set( - 725 - (25 / 2), 250, 50);

        // blanket

		var geometry10 = new THREE.BoxBufferGeometry(440, 10, 650);
		var material5 = new THREE.MeshPhongMaterial( {color: 0x0000ff});
		var blanket1 = new THREE.Mesh( geometry10, material5);
		blanket1.position.set(- 725 - (25 / 2), 305, 150);

        var geometry11 = new THREE.BoxBufferGeometry(60, 10, 650);
        var blanket2 = new THREE.Mesh( geometry11, material5);
        blanket2.position.set(- 955, 280, 150);
        blanket2.rotation.z = Math.PI / 2;

        var blanket3 = blanket2.clone();
        blanket3.position.x += 435;


        bedGroup.add(base1);
        bedGroup.add(base2);
        bedGroup.add(base3);
        bedGroup.add(base4);
        bedGroup.add(base5);
        bedGroup.add(base6);
        bedGroup.add(base7);
        bedGroup.add(base9);
        bedGroup.add(mattress);
        bedGroup.add(blanket1);
        bedGroup.add(blanket2);
        bedGroup.add(blanket3);
        bedGroup.castShadow = true;
        bedGroup.receiveShadow = true;
				return bedGroup;

}
function door(){
	//door features
				var doorGroup;
        var doorFeatures = [360, 800, 50];
      	var doorPosition = [0, doorFeatures[1]/2, 975];
        doorGroup = new THREE.Group();
// point

        var rotationPointGeometry = new THREE.SphereBufferGeometry( 1, 1, 1000 );
        var rotationPointMaterial = new THREE.MeshBasicMaterial( { color : 0xFFFFFF } );
        var rotationPoint = new THREE.Mesh( rotationPointGeometry, rotationPointMaterial );
        rotationPoint.position.set(doorPosition[0] + 200, doorPosition[1], doorPosition[2]);
        doorGroup.add( rotationPoint );
//door

        var doorTexture = new THREE.TextureLoader().load( 'textures/4panel.jpg' );

        var doorGeometry = new THREE.CubeGeometry(doorFeatures[0], doorFeatures[1], doorFeatures[2],);
        var doorMaterial = new THREE.MeshBasicMaterial( {map: doorTexture } );
        var door = new THREE.Mesh( doorGeometry, doorMaterial );
        door.position.set(doorPosition[0], doorPosition[1], doorPosition[2]);
        doorGroup.add( door );

//handle
        var handleTexture = new THREE.TextureLoader().load( 'textures/poignee.jpg' );
        var handleGeometry = new THREE.SphereBufferGeometry( 15, 15, 1000 );
        var handleMaterial = new THREE.MeshBasicMaterial( { map: handleTexture } );
        var handlePosition = [doorPosition[0] - 140, doorPosition[1] * 0.87, doorPosition[2]];

        var handle = new THREE.Mesh( handleGeometry, handleMaterial );
        handle.position.set(handlePosition[0], handlePosition[1], handlePosition[2] + 50);
        doorGroup.add( handle );

        var handle2 = handle.clone();
        handle2.position.z = handlePosition[2] - 50;
        doorGroup.add(  handle2 );

//cylinder between handles
        var betweenHandleGeometry = new THREE.CylinderGeometry( 5, 5, 100, 30 );
        var betweenHandleMaterial = new THREE.MeshBasicMaterial( { map: handleTexture } );
        var betweenHandle = new THREE.Mesh( betweenHandleGeometry, betweenHandleMaterial );
        betweenHandle.position.set(handlePosition[0], handlePosition[1], handlePosition[2]);
        betweenHandle.rotation.x = Math.PI/2;
        doorGroup.add( betweenHandle );

				doorGroup.castShadow = true;
				doorGroup.receiveShadow = true;

        return doorGroup;
}


function poster(scene){
	// post wallpapers

				var post_text =  new THREE.TextureLoader().load( 'textures/prof.jpg' );
				var post_text2 =  new THREE.TextureLoader().load( 'textures/lego.jpg' );
				var post_text3 =  new THREE.TextureLoader().load( 'textures/toy.jpg' );
				var post_text4 =  new THREE.TextureLoader().load( 'textures/pokemon.jpg' );
				var post_text5 =  new THREE.TextureLoader().load( 'textures/yugi.jpg' );
				var post_text6 =  new THREE.TextureLoader().load( 'textures/lego_2.jpg' );


// wallpapers card
				var cont_text = new THREE.TextureLoader().load('textures/wood.jpg');


				var post = new THREE.BoxBufferGeometry(60,90,0);
				var post2 = new THREE.BoxBufferGeometry(580,290,0);
				var post3 = new THREE.BoxBufferGeometry(140,210,0);
				var post4 = new THREE.BoxBufferGeometry(300,240,0);
				var post5 = new THREE.BoxBufferGeometry(190,250,0);
				var post6 = new THREE.BoxBufferGeometry(400,200,0);


				var post_mat = new THREE.MeshBasicMaterial({map :post_text});
				var post_mat2= new THREE.MeshBasicMaterial({map: post_text2})
				var post_mat3= new THREE.MeshBasicMaterial({map: post_text3})
				var post_mat4= new THREE.MeshBasicMaterial({map: post_text4})
				var post_mat5= new THREE.MeshBasicMaterial({map: post_text5})
				var post_mat6= new THREE.MeshBasicMaterial({map: post_text6})

				var post1 = new THREE.Mesh(post,post_mat);
				var post2 = new THREE.Mesh(post2,post_mat2);
				var post3 = new THREE.Mesh(post3,post_mat3);
				var post4 = new THREE.Mesh(post4,post_mat4);
				var post5 = new THREE.Mesh(post5,post_mat5);
				var post6 = new THREE.Mesh(post6,post_mat6);

				post1.position.set(0,200,0);



				post2.position.set(-997,800,+200);
				post2.rotation.y = (pi/2);
				scene.add(post2);

				post3.position.set(-420,800,-395);
				scene.add(post3);

				post4.position.set(490,700,-395);
				scene.add(post4);

				post5.position.set(990,700,545);
				post5.rotation.y = (pi/2);
				scene.add(post5);

				post6.position.set(990,800,45);
				post6.rotation.y = (pi/2);
				scene.add(post6);



// card
				var cont = new THREE.BoxBufferGeometry(60,5,4)
				var cont2 = new THREE.BoxBufferGeometry(5,90,4)
				var back = new THREE.BoxBufferGeometry(55,85,0);
				var supp = new THREE.BoxBufferGeometry(2,50,10);

				var cont_mat = new THREE.MeshBasicMaterial({map: cont_text})
				var cont = new THREE.Mesh(cont,cont_mat);
				var cont2 = new THREE.Mesh(cont2,cont_mat);
				var cont3 = cont2.clone();
				var cont4 = cont.clone();
				var bg = new THREE.Mesh(back,cont_mat);


				cont.position.set(0,245,0);
				cont4.position.set(0,155,0);

				cont2.position.set(-30,200,0);
				cont3.position.set(30,200,0);


				bg.position.set(0,200,-2);

//card foot
				var support = new THREE.Mesh(supp,cont_mat);
				support.position.set(0,180,-20);
				support.rotation.x = (pi/4);

// card + prof + foot
				var picture;
				picture = new THREE.Group()
				picture.add(post1);
				picture.add(cont);
				picture.add(cont);
				picture.add(cont2);
				picture.add(cont3);
				picture.add(cont4);
				picture.add(support);
				picture.add(bg);

				picture.position.set(750,190,-280);
				picture.rotation.set(0,- pi/6, 0);

				scene.add(picture);

}

function bookCase() {
	//bookcase
	var bookCGroup, books;
	bookCGroup = new THREE.Group();
	books = new THREE.Group();
	var bookCTexture = new THREE.TextureLoader().load( 'textures/wood.jpg' );
	var bookCGeometry1 = new THREE.BoxBufferGeometry( 360, 20, 100 );
	var bookCGeometry2 = new THREE.BoxBufferGeometry(20, 420, 100);
	var bookCMaterial = new THREE.MeshPhongMaterial( { map: bookCTexture } );
	var book, book2, books2;

	for (let i = 0; i < 500; i = i + 100) {
		var bookCPiece1 = new THREE.Mesh( bookCGeometry1, bookCMaterial );
		bookCPiece1.position.y += i + 10;
		bookCGroup.add(bookCPiece1);

	}
	for (let i = - 190; i < 300; i = i + 380) {
		var bookCPiece2 = new THREE.Mesh( bookCGeometry2, bookCMaterial);
		bookCPiece2.position.y += 420/2;
		bookCPiece2.position.x = i;
		bookCGroup.add(bookCPiece2);
	}
	loader.load('models/furnitures/book/scene.gltf', function ( gltf ) {
		book = gltf.scene;
		book.scale.set(200,200,200);
		book.position.y += 22;
		book.position.z += 40;
		book.rotation.y = pi / 2;
		books.add( book );

		book2 = book.clone();
		book2.position.x -= 90;
		books.add(book2);
		books.position.y -= 7;

		for (let i = 100; i < 300; i += 100) {
			books2 = books.clone();
			books2.position.y += i;
			books.add(books2);
		}

	});

	bookCGroup.add(books);
	bookCGroup.rotation.y = pi;
	bookCGroup.position.z += 950;
	bookCGroup.position.x += 500;

	bookCGroup.castShadow = true;
	bookCGroup.receiveShadow = true;

	return bookCGroup;
}

function dresser(scene){
				var dresserGroup;
				var dresserGroup = new THREE.Group();
				dresserGroup.applyMatrix( new THREE.Matrix4().makeTranslation(750, 25, 800) );
				dresserGroup.rotation.y = Math.PI/3;

				var dresserFootPosition = [0, 0, 0];
    			var dresserFootGeometry = new THREE.CylinderGeometry( 5, 5, 50, 300 );
  				var dresserFootTexture = new THREE.TextureLoader().load('textures/wood.jpg');
			    var dresserFootMaterial = new THREE.MeshBasicMaterial( { map : dresserFootTexture } );
    			var dresserFoot = new THREE.Mesh( dresserFootGeometry, dresserFootMaterial );
    			dresserFoot.position.set(dresserFootPosition[0] +160, dresserFootPosition[1], dresserFootPosition[2] -60);
    			dresserGroup.add( dresserFoot );

    			var dresserFoot2 = dresserFoot.clone();
    			dresserFoot2.position.set(dresserFootPosition[0] +160, dresserFootPosition[1], dresserFootPosition[2] +60);
    			dresserGroup.add( dresserFoot2 );

    			var dresserFoot3 = dresserFoot.clone();
    			dresserFoot3.position.set(dresserFootPosition[0] -160, dresserFootPosition[1], dresserFootPosition[2] -60);
    			dresserGroup.add( dresserFoot3 );

    			var dresserFoot4 = dresserFoot.clone();
    			dresserFoot4.position.set(dresserFootPosition[0] -160, dresserFootPosition[1], dresserFootPosition[2] +60);
    			dresserGroup.add( dresserFoot4 );


				var dresserTexture = new THREE.TextureLoader().load( 'textures/wood.jpg' );
	        	var dresserGeometry = new THREE.CubeGeometry(350, 10, 140);
    	    	var dresserMaterial = new THREE.MeshBasicMaterial( {map: dresserTexture } );
        		var dresser = new THREE.Mesh( dresserGeometry, dresserMaterial );
        		dresser.position.set(dresserFootPosition[0], dresserFootPosition[1]+30, dresserFootPosition[2]);
        		dresserGroup.add( dresser );

        		var dresser2 = dresser.clone();
        		dresser2.position.set(dresserFootPosition[0], dresserFootPosition[1]+130, dresserFootPosition[2]);
        		dresserGroup.add( dresser2 );

        		var dresser3Texture = new THREE.TextureLoader().load( 'textures/wood.jpg' );
	        	var dresser3Geometry = new THREE.CubeGeometry(110, 10, 140);
    	    	var dresser3Material = new THREE.MeshBasicMaterial( {map: dresserTexture } );
        		var dresser3 = new THREE.Mesh( dresser3Geometry, dresser3Material );
        		dresser3.position.set(dresserFootPosition[0] + 175, dresserFootPosition[1]+80, dresserFootPosition[2]);
        		dresser3.rotation.z = Math.PI/2;
        		dresserGroup.add( dresser3 );

        		var dresser4 = dresser3.clone();
        		dresser4.position.set(dresserFootPosition[0] - 175, dresserFootPosition[1]+80, dresserFootPosition[2]);
        		dresser4.rotation.z = Math.PI/2;
        		dresserGroup.add( dresser4 );

				loader.load('models/flatScreen/scene.gltf', function ( gltf ) {
					var flatScreen = gltf.scene;
					flatScreen.scale.set(150,150,150);
					flatScreen.position.set(dresserFootPosition[0], dresserFootPosition[1] + 231, dresserFootPosition[2]);
					flatScreen.rotation.set(0,-pi,0);
					dresserGroup.add( flatScreen );
    			});
					dresserGroup.castShadow = true;
					dresserGroup.receiveShadow = true;
					dresserGroup.position.set(850,0,700);

				return dresserGroup;

}


export { office, bed, door, poster, bookCase, dresser }
