BEGIN
  	DECLARE prfx VARCHAR(10);
    DECLARE cnt INTEGER(10);
    DECLARE last_cnt VARCHAR(10);

    SELECT msysprefixgoods INTO prfx FROM mconfig where mconfig.id = 1;
	SELECT COUNT(*) INTO cnt FROM mgoods;
    IF (cnt < 10) THEN UPDATE mgoods SET mgoodscode = CONCAT(prfx,'00000',cnt) WHERE mgoods.id = newrow;
    UPDATE mconfig SET msysprefixgoodscount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixgoodslastcount = CONCAT('00000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100) THEN
    UPDATE mgoods SET mgoodscode = CONCAT(prfx,'0000',cnt) WHERE mgoods.id = newrow;
    UPDATE mconfig SET msysprefixgoodscount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixgoodslastcount = CONCAT('0000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000) THEN
    UPDATE mgoods SET mgoodscode = CONCAT(prfx,'000',cnt) WHERE mgoods.id = newrow;
    UPDATE mconfig SET msysprefixgoodscount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixgoodslastcount = CONCAT('000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 10000) THEN
    UPDATE mgoods SET mgoodscode = CONCAT(prfx,'00',cnt) WHERE mgoods.id = newrow;
    UPDATE mconfig SET msysprefixgoodscount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixgoodslastcount = CONCAT('00',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100000) THEN
    UPDATE mgoods SET mgoodscode = CONCAT(prfx,'0',cnt) WHERE mgoods.id = newrow;
    UPDATE mconfig SET msysprefixgoodscount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixgoodslastcount = CONCAT('0',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000000) THEN
    UPDATE mgoods SET mgoodscode = CONCAT(prfx,'',cnt) WHERE mgoods.id = newrow;
    UPDATE mconfig SET msysprefixgoodscount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixgoodslastcount = CONCAT('',cnt) WHERE mconfig.id = 1;
    END IF;
  END
