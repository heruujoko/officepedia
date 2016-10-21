BEGIN
  	DECLARE prfx VARCHAR(10);
    DECLARE cnt INTEGER(10);
    DECLARE last_cnt VARCHAR(10);

    SELECT msysprefixsupplier INTO prfx FROM mconfig where mconfig.id = 1;
	SELECT COUNT(*) INTO cnt FROM msupplier;
    IF (cnt < 10) THEN UPDATE msupplier SET msupplierid = CONCAT(prfx,'00000',cnt) WHERE msupplier.id = newrow;
    UPDATE mconfig SET msysprefixsuppliercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixsupplierlastcount = CONCAT('00000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100) THEN
    UPDATE msupplier SET msupplierid = CONCAT(prfx,'0000',cnt) WHERE msupplier.id = newrow;
    UPDATE mconfig SET msysprefixsuppliercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixsupplierlastcount = CONCAT('0000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000) THEN
    UPDATE msupplier SET msupplierid = CONCAT(prfx,'000',cnt) WHERE msupplier.id = newrow;
    UPDATE mconfig SET msysprefixsuppliercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixsupplierlastcount = CONCAT('000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 10000) THEN
    UPDATE msupplier SET msupplierid = CONCAT(prfx,'00',cnt) WHERE msupplier.id = newrow;
    UPDATE mconfig SET msysprefixsuppliercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixsupplierlastcount = CONCAT('00',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100000) THEN
    UPDATE msupplier SET msupplierid = CONCAT(prfx,'0',cnt) WHERE msupplier.id = newrow;
    UPDATE mconfig SET msysprefixsuppliercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixsupplierlastcount = CONCAT('0',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000000) THEN
    UPDATE msupplier SET msupplierid = CONCAT(prfx,'',cnt) WHERE msupplier.id = newrow;
    UPDATE mconfig SET msysprefixsuppliercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixsupplierlastcount = CONCAT('',cnt) WHERE mconfig.id = 1;
    END IF;
  END
