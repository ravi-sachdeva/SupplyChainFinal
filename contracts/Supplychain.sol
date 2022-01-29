pragma solidity ^0.5.0;

contract Supplychain{

	

	struct State{
		string description;
		string person;
	}

	struct Product{
		string creator;
		string name;
		string desc;
		uint256 id;
		string date;
		uint256 totalStates;
		mapping(uint256 => State) states;
	}

	mapping(uint256 => Product) allProducts;

	uint256 public items=0;

	function get() public  returns (uint256){
		// emit TotalItem(items);
		return items;
	}

	function concat(string memory _a, string memory _b) public returns (string memory){
        bytes memory bytes_a = bytes(_a);
        bytes memory bytes_b = bytes(_b);
        string memory length_ab = new string(bytes_a.length + bytes_b.length);
        bytes memory bytes_c = bytes(length_ab);
        uint k = 0;
        for (uint i = 0; i < bytes_a.length; i++) bytes_c[k++] = bytes_a[i];
        for (uint i = 0; i < bytes_b.length; i++) bytes_c[k++] = bytes_b[i];
        return string(bytes_c);
    }



    function addItem(string memory prodName,string memory author,string memory prodDesc,string memory _date) public returns (bool){
    	Product memory newItem = Product({
    			creator:author,
    			name:prodName,
    			desc:prodDesc,
    			id:items,
    			date:_date,
    			totalStates:0
    		});

    	allProducts[items] = newItem;
    	items = items+1;
    	return true;

    }


    function addState(uint prodId,string memory info,string memory author) public returns (string memory){
    	require(prodId<=items);


    	State memory newState = State({person:author,description:info});
    	allProducts[prodId].states[allProducts[prodId].totalStates]  = newState;
    	allProducts[prodId].totalStates = allProducts[prodId].totalStates+1;

    	return info;

    }






    function uint2str(uint _i) internal pure returns (string memory _uintAsString) {
        if (_i == 0) {
            return "0";
        }
        uint j = _i;
        uint len;
        while (j != 0) {
            len++;
            j /= 10;
        }
        bytes memory bstr = new bytes(len);
        uint k = len;
        while (_i != 0) {
            k = k-1;
            uint8 temp = (48 + uint8(_i - _i / 10 * 10));
            bytes1 b1 = bytes1(temp);
            bstr[k] = b1;
            _i /= 10;
        }
        return string(bstr);
    }








    function searchProduct(uint prodId) public returns (string memory){

    	require(prodId<=items);


    	string memory  output = "";
    	string memory strid = uint2str(prodId);

    	output=concat(output,strid);
    	output=concat(output,"/");
    	output=concat(output,allProducts[prodId].name);
    	output=concat(output,"/");
    	output=concat(output,allProducts[prodId].desc);
    	output=concat(output,"/");
    	output=concat(output,allProducts[prodId].date);
    	output=concat(output,"/");

    	for(uint256 j=0;j<allProducts[prodId].totalStates;j++){
    		output = concat(output,allProducts[prodId].states[j].person);
    		output = concat(output,"*");
    		output = concat(output,allProducts[prodId].states[j].description);
    		output = concat(output,"$");

    	}
    	return output;


    }

}