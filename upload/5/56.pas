{ JC05: Chiu Jiawei, Hwa Chong JC }

program p2_image;

var
    map: array[1..64, 1..64] of byte;
    n, i, j: integer;
    fin, fout: text;

(* x is either 0 or 1 *)
function check(x1, y1, x2, y2, x: integer): boolean;
var
    i,j: integer;
begin
    for i:= y1 to y2 do
        for j:= x1 to x2 do
            if map[i, j] <> x then
            begin
                check:= false;
                exit;
            end;

    check:= true;
end;

function process(x1, y1, x2, y2: integer): longint;
var
    midx, midy: integer;
begin

    if check(x1,y1,x2,y2, map[y1,x1]) then
        process:= 2
    else
    begin
        midx:= (x1+x2) div 2;
        midy:= (y1+y2) div 2;
        process:= 1 + process(x1,y1,midx,midy)
                    + process(midx+1,y1,x2,midy)
                    + process(x1,midy+1,midx,y2)
                    + process(midx+1,midy+1,x2,y2);
    end;

end;

begin

    assign(fin, 'image.in');
    reset(fin);

    readln(fin, n);
    for i:= 1 to n do
        for j:= 1 to n do
            read(fin, map[i,j]);

    assign(fout, 'image.out');
    rewrite(fout);
    writeln(fout, process(1, 1, n, n));
    close(fout);

end.

